            <div class="page-title">
				<ul class="breadcrumb breadcrumb-caret position-right">
					<li><a href="{{ action("HomeController@index") }}">{{ trans('messages.home') }}</a></li>
					<li><a href="{{ action("PRListController@index") }}">{{ trans('messages.lists') }}</a></li>
					<li>
						<div class="btn-group other-lists">
							<button type="button" class="btn btn-link dropdown-toggle text-teal-600" data-toggle="dropdown">{{ trans('messages.change_list') }} <span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-right">
								@forelse ($list->otherLists() as $l)
									<li>
										<a href="{{ action('PRListController@overview', ['list_uid' => $l->uid]) }}">
											{{ $l->longName() }}
										</a>
									</li>
								@empty
									<li><a href="#">({{ trans('messages.empty') }})</a></li>
								@endforelse
							</ul>
						</div>
					</li>
				</ul>
					
				<h1>
					<span class="text-semibold">{{ $list->name }}</span>
				</h1>
				<span class="badge badge-info bg-info-800 badge-big">{{ $list->subscribers()->count() }}</span> {{ trans('messages.subscribers') }}
			</div>