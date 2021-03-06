<?php

namespace Acelle\Http\Controllers;

use Illuminate\Http\Request;
use Acelle\Model\Subscriber;
use Acelle\Model\EmailVerificationServer;
use Acelle\Library\Log as MailLog;

class PRSubscriberController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);
        $subscribers = $list->subscribers;

        return view('prsubscribers.index', [
            'subscribers' => $subscribers,
            'list' => $list,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);

        // // authorize
        // if (\Gate::denies('read', $list)) {
        //     return;
        // }

        $subscribers = \Acelle\Model\PRSubscriber::search($request)
                                        ->where('p_r_list_id', '=', $list->id)
                                        ->paginate($request->per_page);
        $fields = $list->getFields->whereIn('uid', explode(',', $request->columns));

        return view('prsubscribers._list', [
            'subscribers' => $subscribers,
            'list' => $list,
            'fields' => $fields,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);
        $subscriber = new \Acelle\Model\PRSubscriber();
        $subscriber->p_r_list_id = $list->id;

        // // authorize
        // if (\Gate::denies('create', $subscriber)) {
        //     return $this->noMoreItem();
        // }

        // Get old post values
        $values = [];
        if (null !== $request->old()) {
            foreach ($request->old() as $key => $value) {
                if (is_array($value)) {
                    $values[str_replace('[]', '', $key)] = implode(',', $value);
                } else {
                    $values[$key] = $value;
                }
            }
        }

        return view('prsubscribers.create', [
            'list' => $list,
            'subscriber' => $subscriber,
            'values' => $values,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = $request->user()->customer;
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);
        $subscriber = new \Acelle\Model\PRSubscriber();
        $subscriber->p_r_list_id = $list->id;
        $subscriber->status = 'subscribed';

        // // authorize
        // if (\Gate::denies('create', $subscriber)) {
        //     return $this->noMoreItem();
        // }

        // validate and save posted data
        if ($request->isMethod('post')) {
            $this->validate($request, $subscriber->getRules());

            // Save subscriber
            $subscriber->email = $request->EMAIL;
            $subscriber->save();
            // Update field
            $subscriber->updateFields($request->all());

            // update MailList cache
            $subscriber->mailList->updateCachedInfo();

            // Log
            $subscriber->log('created', $customer);

            // Redirect to my lists page
            $request->session()->flash('alert-success', trans('messages.subscriber.created'));

            return redirect()->action('PRSubscriberController@index', $list->uid);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);
        $subscriber = \Acelle\Model\PRSubscriber::findByUid($request->uid);

        // // authorize
        // if (\Gate::denies('update', $subscriber)) {
        //     return $this->notAuthorized();
        // }

        // Get old post values
        $values = [];
        foreach ($list->getFields as $key => $field) {
            $values[$field->tag] = $subscriber->getValueByField($field);
        }
        if (null !== $request->old()) {
            foreach ($request->old() as $key => $value) {
                if (is_array($value)) {
                    $values[str_replace('[]', '', $key)] = implode(',', $value);
                } else {
                    $values[$key] = $value;
                }
            }
        }

        return view('prsubscribers.edit', [
            'list' => $list,
            'subscriber' => $subscriber,
            'values' => $values,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = $request->user()->customer;
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);
        $subscriber = \Acelle\Model\PRSubscriber::findByUid($request->uid);

        // authorize
        if (\Gate::denies('update', $subscriber)) {
            return $this->notAuthorized();
        }

        // validate and save posted data
        if ($request->isMethod('patch')) {
            $this->validate($request, $subscriber->getRules());

            // Update field
            $subscriber->updateFields($request->all());

            // Log
            $subscriber->log('updated', $customer);

            // Redirect to my lists page
            $request->session()->flash('alert-success', trans('messages.subscriber.updated'));

            return redirect()->action('PRSubscriberController@index', $list->uid);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $customer = $request->user()->customer;
        $subscribers = \Acelle\Model\PRSubscriber::whereIn('uid', explode(',', $request->uids));

        // get related mail lists to update the cached information
        $lists = $subscribers->get()->map(function($e) { return \Acelle\Model\PRList::find($e->p_r_list_id); })->unique();

        // actually delete the subscriber
        foreach ($subscribers->get() as $subscriber) {
            // authorize
            // if (\Gate::denies('delete', $subscriber)) {
                return;
            // }
        }

        foreach ($subscribers->get() as $subscriber) {
            $subscriber->delete();

            // Log
            $subscriber->log('deleted', $customer);
        }

        foreach ($lists as $list) {
            $list->updateCachedInfo();
        }

        // Redirect to my lists page
        echo trans('messages.subscribers.deleted');
    }

    /**
     * Subscribe subscriber.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function subscribe(Request $request)
    {
        $customer = $request->user()->customer;
        $subscribers = \Acelle\Model\PRSubscriber::whereIn('uid', explode(',', $request->uids));

        foreach ($subscribers->get() as $subscriber) {
            // authorize
            //if (\Gate::denies('subscribe', $subscriber)) {
                return;
           // }
        }

        foreach ($subscribers->get() as $subscriber) {
            $subscriber->status = 'subscribed';
            $subscriber->save();

            // Log
            $subscriber->log('subscribed', $customer);
        }

        // Redirect to my lists page
        echo trans('messages.subscribers.subscribed');
    }

    /**
     * Unsubscribe subscriber.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function unsubscribe(Request $request)
    {
        $customer = $request->user()->customer;
        $subscribers = \Acelle\Model\PRSubscriber::whereIn('uid', explode(',', $request->uids));

        foreach ($subscribers->get() as $subscriber) {
            // authorize
            //if (\Gate::denies('unsubscribe', $subscriber)) {
                return;
            //}
        }

        foreach ($subscribers->get() as $subscriber) {
            $subscriber->status = 'unsubscribed';
            $subscriber->save();

            // Log
            $subscriber->log('unsubscribed', $customer);
        }

        // Redirect to my lists page
        echo trans('messages.subscribers.unsubscribed');
    }

    /**
     * Import from file.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        $customer = $request->user()->customer;
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);

        $system_jobs = $list->importJobs();

        // authorize
       // if (\Gate::denies('import', $list)) {
            return $this->notAuthorized();
        //}

        if ($request->isMethod('post')) {
            if ($request->hasFile('file')) {
                // Start system job
                $job = new \Acelle\Jobs\ImportSubscribersJob($list, $request->user()->customer, $request->file('file')->path());
                $this->dispatch($job);

                // Action Log
                $list->log('import_started', $request->user()->customer);
            } else {
                // @note: use try/catch instead
                echo "max_file_upload";
            }
        } else {
            return view('prsubscribers.import', [
                'list' => $list,
                'system_jobs' => $system_jobs
            ]);
        }
    }

    /**
     * Check import proccessing.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function importProccess(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->current_list_uid);
        $system_job = $list->getLastImportJob();

        // // authorize
        // if (\Gate::denies('import', $list)) {
        //     return $this->notAuthorized();
        // }

        if(!is_object($system_job)) {
            return "none";
        }

        // // authorize
        // if (\Gate::denies('import', $list)) {
        //     return $this->notAuthorized();
        // }

        // Messages
        $message = \Acelle\Helpers\ImportSubscribersHelper::getMessage($system_job);

        return response()->json([
            "job" => $system_job,
            "data" => json_decode($system_job->data),
            "timer" => $system_job->runTime(),
            "message" => $message,
        ]);
    }

    /**
     * Download import log.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     * @todo move this to the MailList controller
     */
    public function downloadImportLog(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);

        // // authorize
        // if (\Gate::denies('import', $list)) {
        //     return $this->notAuthorized();
        // }

        // @todo: should be the exact MailList here
        $log = $list->getLastImportLog();
        // @todo what if log does not exist (removed)?
        return response()->download($log);
    }

    /**
     * Display a listing of subscriber import job.
     *
     * @return \Illuminate\Http\Response
     */
    public function importList(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);

        // // authorize
        // if (\Gate::denies('import', $list)) {
        //     return $this->notAuthorized();
        //}

        $system_jobs = $list->importJobs();
        $system_jobs = $system_jobs->orderBy($request->sort_order, $request->sort_direction);
        $system_jobs = $system_jobs->paginate($request->per_page);

        return view('prsubscribers._import_list', [
            'system_jobs' => $system_jobs,
            'list' => $list
        ]);
    }

    /**
     * Export to csv.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function export(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);

        // // authorize
        // if (\Gate::denies('export', $list)) {
        //     return $this->notAuthorized();
        // }

        $system_jobs = $list->exportJobs();

        $customer = $request->user()->customer;

        // // authorize
        // if (\Gate::denies('export', $list)) {
        //     return $this->notAuthorized();
        // }

        if ($request->isMethod('post')) {

            // Start system job
            $job = new \Acelle\Jobs\ExportSubscribersJob($list, $request->user());
            $this->dispatch($job);

            // Action Log
            $list->log('export_started', $request->user()->customer);
        } else {
            return view('prsubscribers.export', [
                'list' => $list,
                'system_jobs' => $system_jobs
            ]);
        }
    }

    /**
     * Check export proccessing.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function exportProccess(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->current_list_uid);
        $system_job = $list->getLastExportJob();

        // // authorize
        // if (\Gate::denies('export', $list)) {
        //     return $this->notAuthorized();
        // }

        if(!is_object($system_job)) {
            return "none";
        }

        // // authorize
        // if (\Gate::denies('export', $list)) {
        //     return $this->notAuthorized();
        // }

        return response()->json([
            "job" => $system_job,
            "data" => json_decode($system_job->data),
            "timer" => $system_job->runTime(),
        ]);
    }

    /**
     * Download exported csv file after exporting.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadExportedCsv(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);

        // // authorize
        // if (\Gate::denies('export', $list)) {
        //     return $this->notAuthorized();
        // }

        $system_job = $list->getLastExportJob();

        return response()->download(storage_path('job/'.$system_job->id.'/data.csv'));
    }

    /**
     * Display a listing of subscriber import job.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportList(Request $request)
    {
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);

        // // authorize
        // if (\Gate::denies('export', $list)) {
        //     return $this->notAuthorized();
        // }

        $system_jobs = $list->exportJobs();
        $system_jobs = $system_jobs->orderBy($request->sort_order, $request->sort_direction);
        $system_jobs = $system_jobs->paginate($request->per_page);

        return view('prsubscribers._export_list', [
            'system_jobs' => $system_jobs,
            'list' => $list
        ]);
    }

    /**
     * Copy subscribers to lists.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request)
    {
        $subscribers = \Acelle\Model\PRSubscriber::whereIn('uid', explode(',', $request->uids));
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);
        $from_list = $subscribers->first()->mailList;

        foreach ($subscribers->get() as $subscriber) {
            // authorize
            //if (\Gate::denies('update', $subscriber)) {
                return;
           // }
        }

        foreach (\Acelle\Model\Subscriber::whereIn('uid', explode(',', $request->uids))->get() as $subscriber) {
            $subscriber->copy($list, $request->type);
        }

        // Trigger updating related campaigns cache
        $from_list->updateCachedInfo();
        $list->updateCachedInfo();

        // Log
        $list->log('copied', $request->user()->customer, [
            'count' => $subscribers->count(),
            'from_uid' => $from_list->uid,
            'to_uid' => $list->uid,
            'from_name' => $from_list->name,
            'to_name' => $list->name,
        ]);

        // Redirect to my lists page
        echo trans('messages.subscribers.copied');
    }

    /**
     * Move subscribers to lists.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function move(Request $request)
    {
        $subscribers = \Acelle\Model\PRSubscriber::whereIn('uid', explode(',', $request->uids));
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);
        $from_list = $subscribers->first()->mailList;

        foreach ($subscribers->get() as $subscriber) {
            // authorize
            //if (\Gate::denies('update', $subscriber)) {
                return;
           // }
        }

        foreach (\Acelle\Model\PRSubscriber::whereIn('uid', explode(',', $request->uids))->get() as $subscriber) {
            $subscriber->move($list, $request->type);
        }

        // Trigger updating related campaigns cache
        $from_list->updateCachedInfo();
        $list->updateCachedInfo();

        // Log
        $list->log('moved', $request->user()->customer, [
            'count' => $subscribers->count(),
            'from_uid' => $from_list->uid,
            'to_uid' => $list->uid,
            'from_name' => $from_list->name,
            'to_name' => $list->name,
        ]);

        // Redirect to my lists page
        echo trans('messages.subscribers.moved');
    }

    /**
     * Copy Move subscribers form.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function copyMoveForm(Request $request)
    {
        $subscribers = \Acelle\Model\PRSubscriber::whereIn('uid', explode(',', $request->uids));
        $list = \Acelle\Model\PRList::findByUid($request->list_uid);

        return view('prsubscribers.copy_move_form', [
            'subscribers' => $subscribers,
            'list' => $list
        ]);
    }

    /**
     * Start the verification process
     *
     */
    public function startVerification(Request $request)
    {
        $subscriber = PRSubscriber::findByUid($request->uid);
        $server = EmailVerificationServer::findByUid($request->email_verification_server_id);
        try {
            $subscriber->verify($server);

            // success message
            $request->session()->flash('alert-success', trans('messages.verification.finish'));

            return redirect()->action('PRSubscriberController@edit', ['list_uid' => $request->list_uid, 'uid' => $subscriber->uid]);
        } catch (\Exception $e) {
            MailLog::error(sprintf("Something went wrong while verifying %s (%s). Error message: %s", $subscriber->email, $subscriber->id, $e->getMessage()));
            return view('somethingWentWrong', ['message' => sprintf("Something went wrong while verifying %s (%s). Error message: %s", $subscriber->email, $subscriber->id, $e->getMessage())]);
        }
    }

    /**
     * Reset the verification data
     *
     */
    public function resetVerification(Request $request)
    {
        $subscriber = Subscriber::findByUid($request->uid);

        try {
            MailLog::info(sprintf("Cleaning up verification data for %s (%s)", $subscriber->email, $subscriber->id));
            $subscriber->emailVerification->delete();
            // success message
            $request->session()->flash('alert-success', trans('messages.verification.reset'));

            MailLog::info(sprintf("Finish cleaning up verification data for %s (%s)", $subscriber->email, $subscriber->id));
            return redirect()->action('SubscriberController@edit', ['list_uid' => $request->list_uid, 'uid' => $subscriber->uid]);
        } catch (\Exception $e) {
            MailLog::error(sprintf("Something went wrong while cleaning up verification data for %s (%s). Error message: %s", $subscriber->email, $subscriber->id, $e->getMessage()));
            return view('somethingWentWrong', ['message' => sprintf("Something went wrong while cleaning up verification data for %s (%s). Error message: %s", $subscriber->email, $subscriber->id, $e->getMessage())]);
        }
    }
}
