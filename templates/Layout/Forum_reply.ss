<% include SilverStripe\Forum\Includes\ForumHeader %>
	$PostMessageForm

	<div id="PreviousPosts">
		<ul id="Posts">
			<% loop $Posts('DESC') %>
				<li class="$EvenOdd">
					<% include SilverStripe\Forum\Includes\SinglePost %>
				</li>
			<% end_loop %>
		</ul>
		<div class="clear"><!-- --></div>
	</div>

<% include SilverStripe\Forum\Includes\ForumFooter %>
