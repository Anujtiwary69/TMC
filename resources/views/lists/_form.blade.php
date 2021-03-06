          <div class="sub_section">
                        <h2 class="text-semibold text-teal-800">{{ trans('messages.list_details') }}</h2>

                        <div class="row">
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'name', 'value' => $list->name, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'from_email', 'label' => trans('messages.default_from_email_address'), 'value' => $list->from_email, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'from_name', 'label' => trans('messages.default_from_name'), 'value' => $list->from_name, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'default_subject', 'label' => trans('messages.default_email_subject'), 'value' => $list->default_subject, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>

                        </div>
                    </div>

                    <div class="sub_section">
                        <h2 class="text-semibold text-teal-800">
                            {{ trans('messages.contact_information') }}
                            <span class="subhead">{!! trans('messages.default_from_your_contact_information', ['link' => action('AccountController@contact')]) !!}</span>
                        </h2>

                        <div class="row">
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'contact[company]', 'label' => trans('messages.company_organization'), 'value' => $list->contact->company, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'contact[state]', 'label' => trans('messages.state_province_region'), 'value' => $list->contact->state, 'rules' => Acelle\Model\MailList::$rules])

                            </div>

                        </div>

                            <div class="row">
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'contact[address_1]', 'label' => trans('messages.address_1'), 'value' => $list->contact->address_1, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'contact[city]', 'label' => trans('messages.city'), 'value' => $list->contact->city, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'contact[address_2]', 'label' => trans('messages.address_2'), 'value' => $list->contact->address_2, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'contact[zip]', 'label' => trans('messages.zip_postal_code'), 'value' => $list->contact->zip, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'select', 'name' => 'contact[country_id]', 'label' => trans('messages.country'), 'value' => $list->contact->country_id, 'options' => Acelle\Model\Country::getSelectOptions(), 'include_blank' => trans('messages.choose'), 'rules' => Acelle\Model\MailList::$rules])

                            </div>
                            <div class="col-md-6">

                                    @include('helpers.form_control', ['type' => 'text', 'name' => 'contact[phone]', 'label' => trans('messages.phone'), 'value' => $list->contact->phone, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>

                        </div>


                        <div class="row">
                            <div class="col-md-6">

                                @include('helpers.form_control', ['type' => 'text', 'name' => 'contact[email]', 'label' => trans('messages.email'), 'value' => $list->contact->email, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>
                            <div class="col-md-6">

                                @include('helpers.form_control', ['type' => 'text', 'name' => 'contact[url]', 'label' => trans('messages.url'), 'label' => trans('messages.home_page'), 'value' => $list->contact->url, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                            </div>
                        </div>
                    </div>

                    <div class="sub_section">
                        <h2 class="text-semibold text-teal-800">{{ trans('messages.settings') }}</h2>
                        <div class="row">
                            <div class="col-md-6 hide">

                                @include('helpers.form_control', ['type' => 'text', 'name' => 'email_subscribe', 'value' => $list->email_subscribe, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                                @include('helpers.form_control', ['type' => 'text', 'name' => 'email_unsubscribe', 'value' => $list->email_unsubscribe, 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                                <br />

                            </div>
                            <div class="col-md-6">
                                <div class="form-group checkbox-right-switch">
                                    @include('helpers.form_control', [
                                        'type' => 'checkbox',
                                        'name' => 'subscribe_confirmation',
                                        'value' => $list->subscribe_confirmation,
                                        'options' => [false,true],
                                        'help_class' => 'list',
                                        'rules' => Acelle\Model\MailList::$rules
                                    ])

                                    @include('helpers.form_control', ['type' => 'checkbox', 'name' => 'unsubscribe_notification', 'value' => $list->unsubscribe_notification, 'options' => [false,true], 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])
                                </div>
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group checkbox-right-switch">

                                        @include('helpers.form_control', ['type' => 'checkbox', 'name' => 'send_welcome_email', 'value' => $list->send_welcome_email, 'options' => [false,true], 'help_class' => 'list', 'rules' => Acelle\Model\MailList::$rules])

                                    </div>
                            </div>

                        </div>
                    </div>


                    @if (Auth::user()->customer->can('create', new Acelle\Model\SendingServer()))
                        <div class="sub_section">
                            <h2 class="text-semibold text-teal-800">{{ trans('messages.sending_servers') }}</h2>
                            <div class="row">
                                <div class="col-md-3">
                                    {{ trans('messages.use_all_sending_servers') }}&nbsp;&nbsp;&nbsp;
                                    <span class="notoping">
                                        @include('helpers.form_control', ['type' => 'checkbox',
                                            'class' => '',
                                            'name' => 'all_sending_servers',
                                            'value' => $list->all_sending_servers,
                                            'label' => '',
                                            'options' => [false,true],
                                            'help_class' => 'list',
                                            'rules' => Acelle\Model\MailList::$rules
                                        ])
                                    </span>

                                </div>
                            </div>
                            @if(!\Auth::user()->customer->activeSendingServers()->count())
                                <div class="empty-list">
                                    <i class="icon-server"></i>
                                    <span class="line-1">
                                        {{ trans('messages.sending_server_no_active') }}
                                    </span>
                                </div>
                            @endif
                            <br />
                            <div class="row sending-servers">
                                @foreach (\Auth::user()->customer->activeSendingServers()->orderBy("name")->get() as $server)
                                    <div class="col-md-6">
                                        <h5 class="mt-0 mb-5 text-semibold text-teal-600 {{ $server->status != \Acelle\Model\SendingServer::STATUS_ACTIVE ? 'inactive' : '' }}">
                                            {{ $server->name }}
                                            <span class="label label-flat bg-{{ $server->status }}">{{ trans('messages.sending_server_status_' . $server->status) }}</span>
                                        </h5>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label class="mt-0 mb-5 text-semibold">{{ trans('messages.choose') }}</label>
                                                    @include('helpers.form_control', [
                                                        'type' => 'checkbox',
                                                        'name' => 'sending_servers[' . $server->uid . '][check]',
                                                        'value' => $list->mailListsSendingServers->contains('sending_server_id', $server->id),
                                                        'label' => '',
                                                        'options' => [false, true],
                                                        'help_class' => 'list',
                                                        'rules' => Acelle\Model\MailList::$rules
                                                    ])
                                                </div>
                                                <br><br>
                                            </div>
                                            <div class="col-md-9">
                                                @include('helpers.form_control', [
                                                    'type' => 'text',
                                                    'class' => 'numeric',
                                                    'name' => 'sending_servers[' . $server->uid . '][fitness]',
                                                    'label' => trans('messages.fitness'),
                                                    'value' => (is_object($list->mailListsSendingServers()->where('sending_server_id', $server->id)->first()) ? $list->mailListsSendingServers()->where('sending_server_id', $server->id)->first()->fitness : "100"),
                                                    'help_class' => 'list',
                                                    'rules' => Acelle\Model\MailList::$rules
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                // all sending servers checking
                                $(document).on("change", "input[name='all_sending_servers']", function(e) {
                                    if($("input[name='all_sending_servers']:checked").length) {
                                        $(".sending-servers").find("input[type=checkbox]").each(function() {
                                            if($(this).is(":checked")) {
                                                $(this).parents(".form-group").find(".switchery").eq(1).click();
                                            }
                                        });
                                        $(".sending-servers").hide();
                                    } else {
                                        $(".sending-servers").show();
                                    }
                                });
                                $("input[name='all_sending_servers']").trigger("change");
                            });
                        </script>
                    @endif
