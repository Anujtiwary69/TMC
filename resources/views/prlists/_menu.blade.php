                                    <div class="row">
										<div class="col-md-12">
											<ul class="nav nav-tabs nav-tabs-top page-second-nav">
                                                <li rel0="PRListController/overview" class="dropdown">
													<a href="{{ action('PRListController@overview', $list->uid) }}" class="level-1">
														<i class="icon-stats-bars3"></i> {{ trans('messages.overview') }}
													</a>
												</li>
												<li rel0="PRListController/edit">
													<a class="level-1" href="{{ action('PRListController@edit', $list->uid) }}">
														<i class="icon-pencil7"></i> {{ trans('messages.list_information') }}
													</a>
												</li>
												<li rel0="PRSubscriberController" class="dropdown">
													<a href="{{ action("AccountController@contact") }}" class="level-1" data-toggle="dropdown">
														<i class="icon-users4 position-left"></i> {{ trans('messages.subscribers') }}
                                                        <span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li rel0="PRSubscriberController/index">
                                                            <a href="{{ action('PRSubscriberController@index', $list->uid) }}">
                                                                <i class="icon-list2"></i> {{ trans('messages.view_all') }}
                                                            </a>
                                                        </li>
                                                        <li rel0="PRSubscriberController/create">
                                                            <a href="{{ action('PRSubscriberController@create', $list->uid) }}">
                                                                <i class="icon-plus2"></i> {{ trans('messages.add') }}
                                                            </a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        @if (\Auth::user()->can('import', $list))
                                                            <li rel0="PRSubscriberController/import">
                                                                <a href="{{ action('PRSubscriberController@import', $list->uid) }}">
                                                                    <i class="icon-download4"></i> {{ trans('messages.import') }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                        @if (\Auth::user()->can('export', $list))
                                                            <li rel0="PRSubscriberController/export">
                                                                <a href="{{ action('PRSubscriberController@export', $list->uid) }}">
                                                                    <i class="icon-upload4"></i> {{ trans('messages.export') }}
                                                                </a>
                                                            </li>
                                                        @endif
                                                    </ul>
												</li>
                                               {{--  <li rel0="SegmentController" class="dropdown">
													<a href="{{ action("AccountController@contact") }}" class="level-1" data-toggle="dropdown">
														<i class="icon-make-group position-left"></i> {{ trans('messages.segments') }}
                                                        <span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right">
                                                        <li rel0="SegmentController/index">
                                                            <a href="{{ action('PRSegmentController@index', $list->uid) }}">
                                                                <i class="icon-list2"></i> {{ trans('messages.view_all') }}
                                                            </a>
                                                        </li>
                                                        <li rel0="PRSegmentController/create">
                                                            <a href="{{ action('PRSegmentController@create', $list->uid) }}">
                                                                <i class="icon-plus2"></i> {{ trans('messages.add') }}
                                                            </a>
                                                        </li>
                                                    </ul>
												</li> --}}
                                                <li rel0="PRPageController" rel1="PRListController/embeddedForm" class="dropdown">
													<a href="#menu" class="level-1" data-toggle="dropdown">
														<i class="icon-certificate position-left"></i> {{ trans('messages.custom_forms_and_emails') }}
                                                        <span class="caret"></span>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-right has-head">
														<li>
                                                            <a href="{{ action('PRListController@embeddedForm', $list->uid) }}">
                                                                <i class="icon-embed2"></i> {{ trans('messages.Embedded_form') }}
                                                            </a>
                                                        </li>
                                                        <li class="head">
                                                            <i class="icon-enter"></i> {{ trans('messages.subscribe') }}
                                                        </li>
                                                        <li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'sign_up_form']) }}">
                                                                {{ trans('messages.sign_up_form') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a  href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'sign_up_thankyou_page']) }}">
                                                                {{ trans('messages.sign_up_thankyou_page') }}
                                                            </a>
                                                        </li>
														<li>
                                                            <a  href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'sign_up_confirmation_email']) }}">
                                                                {{ trans('messages.sign_up_confirmation_email') }}
                                                            </a>
                                                        </li>
														<li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'sign_up_confirmation_thankyou']) }}">
                                                                {{ trans('messages.sign_up_confirmation_thankyou') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'sign_up_welcome_email']) }}">
                                                                {{ trans('messages.sign_up_welcome_email') }}
                                                            </a>
                                                        </li>
                                                        <li class="head">
                                                            <i class="icon-exit"></i> {{ trans('messages.unsubscribe') }}
                                                        </li>
                                                        <li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'unsubscribe_form']) }}">
                                                                {{ trans('messages.unsubscribe_form') }}
                                                            </a>
                                                        </li>
														<li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'unsubscribe_success_page']) }}">
                                                                {{ trans('messages.unsubscribe_success_page') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'unsubscribe_goodbye_email']) }}">
                                                                {{ trans('messages.unsubscribe_goodbye_email') }}
                                                            </a>
                                                        </li>
                                                        <li class="head">
                                                            <i class="icon-profile"></i> {{ trans('messages.update_profile') }}
                                                        </li>
														<li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'profile_update_email_sent']) }}">
                                                                {{ trans('messages.profile_update_email_sent') }}
                                                            </a>
                                                        </li>
														<li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'profile_update_email']) }}">
                                                                {{ trans('messages.profile_update_email') }}
                                                            </a>
                                                        </li>
														<li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'profile_update_form']) }}">
                                                                {{ trans('messages.profile_update_form') }}
                                                            </a>
                                                        </li>
														<li>
                                                            <a href="{{ action('PRPageController@update', ['list_uid' => $list->uid, 'alias' => 'profile_update_success_page']) }}">
                                                                {{ trans('messages.profile_update_success_page') }}
                                                            </a>
                                                        </li>
                                                    </ul>
												</li>
												{{-- <li rel0="PRFieldController/index">
													<a class="level-1" href="{{ action('PRFieldController@index', $list->uid) }}">
														<i class="icon-list3"></i> {{ trans('messages.manage_list_fields') }}
													</a>
												</li> --}}
												{{-- <li rel0="PRListController/verification">
													<a class="level-1" href="{{ action('PRListController@verification', $list->uid) }}">
														<i class="icon-envelop5"></i> {{ trans('messages.email_verification') }}
													</a>
												</li> --}}
											</ul>
										</div>
									</div>
