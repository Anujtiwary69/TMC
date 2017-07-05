<div class="row">
	<div class="col-md-12">
		<ul class="nav nav-tabs nav-tabs-top page-second-nav">
			<li rel0="PRCampaignController/overview" class="dropdown">
				<a href="{{ action('PRCampaignController@overview', $campaign->uid) }}" class="level-1">
					<i class="icon-stats-bars3"></i> {{ trans('messages.overview') }}
				</a>
			</li>
			<li rel0="PRCampaignController/links" class="dropdown">
				<a href="{{ action('PRCampaignController@links', $campaign->uid) }}" class="level-1">
					<i class="icon-link"></i> {{ trans('messages.links') }}
				</a>
			</li>
			<li rel0="PRCampaignController/openMap" class="dropdown">
				<a href="{{ action('PRCampaignController@openMap', $campaign->uid) }}" class="level-1">
					<i class="icon-map4"></i> {{ trans('messages.open_map') }}
				</a>
			</li>
			<li rel0="PRCampaignController/subscribers" class="dropdown">
				<a href="{{ action('CampaignController@subscribers', $campaign->uid) }}" class="level-1">
					<i class="icon-users"></i> {{ trans('messages.subscribers') }}
				</a>
			</li>
			<li class="dropdown"
				rel0="PRCampaignController/trackingLog"
				rel1="PRCampaignController/bounceLog"
				rel2="PRCampaignController/feedbackLog"
				rel3="PRCampaignController/openLog"
				rel4="PRCampaignController/clickLog"
				rel5="PRCampaignController/unsubscribeLog"
			>
				<a href="{{ action("PRAccountController@contact") }}" class="level-1" data-toggle="dropdown">
					<i class="icon-file-text2 position-left"></i> {{ trans('messages.sending_logs') }}
					<span class="caret"></span>
				</a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li rel0="CampaignController/trackingLog" class="dropdown">
						<a href="{{ action('PRCampaignController@trackingLog', $campaign->uid) }}">
							<i class="icon-file-text2"></i> {{ trans('messages.tracking_log') }}
						</a>
					</li>
					<li rel0="CampaignController/bounceLog" class="dropdown">
						<a href="{{ action('PRCampaignController@bounceLog', $campaign->uid) }}">
							<i class="icon-file-text2"></i> {{ trans('messages.bounce_log') }}
						</a>
					</li>
					<li rel0="CampaignController/feedbackLog" class="dropdown">
						<a href="{{ action('PRCampaignController@feedbackLog', $campaign->uid) }}">
							<i class="icon-file-text2"></i> {{ trans('messages.feedback_log') }}
						</a>
					</li>
					<li rel0="CampaignController/openLog" class="dropdown">
						<a href="{{ action('PRCampaignController@openLog', $campaign->uid) }}">
							<i class="icon-file-text2"></i> {{ trans('messages.open_log') }}
						</a>
					</li>
					<li rel0="CampaignController/clickLog" class="dropdown">
						<a href="{{ action('PRCampaignController@clickLog', $campaign->uid) }}">
							<i class="icon-file-text2"></i> {{ trans('messages.click_log') }}
						</a>
					</li>
					<li rel0="CampaignController/unsubscribeLog" class="dropdown">
						<a href="{{ action('PRCampaignController@unsubscribeLog', $campaign->uid) }}">
							<i class="icon-file-text2"></i> {{ trans('messages.unsubscribe_log') }}
						</a>
					</li>
				</ul>
			</li>
			<!--<li rel0="CampaignController/templateReview" class="dropdown">
				<a href="{{ action('PRCampaignController@templateReview', $campaign->uid) }}" class="level-1">
					<i class="icon-magazine"></i> {{ trans('messages.template') }}
				</a>
			</li>-->
		</ul>
	</div>
</div>