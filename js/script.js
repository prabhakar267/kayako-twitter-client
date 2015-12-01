$(document).ready(function(){
	showTweets();
});

function showTweets(){
	var targ = $('#tweets_displayed'),
		url = 'index.php/fetch-tweets';

	$.ajax({
        url : url,
        success : function(data){
        	data = jQuery.parseJSON(data);

            if(!data.error){
                targ.html('');
                for (var tweet in data.tweets) {
                	var temp = data.tweets[tweet],
						string 	= "<div class='tweet-div'>"
                				+ "<img src='" + temp.user.image_pr + "' class='img-thumbnail timeline' width='50'>"
								+ "<p><a href='https://www.twitter.com/" + temp.user.handle + "' target='_blank'>" + temp.user.name + " <span class='text-muted'>@" + temp.user.handle + "</span></a></p>"
								+ temp.text + "<br>"
								+ "<span class='text-muted small'>" + temp.time + "</span>"
								+ "</div>";

// <div class="tweet-div">
// 	<img src="https://pbs.twimg.com/profile_images/618089496391749633/4J_sDhIw_normal.png">
// 	<a href="https://www.twitter.com/TrideaPartners" target="_blank">
// 		<span class="text-muted">@TrideaPartners</span>
// 		Tridea Partners
// 	</a>
// 	<p>
// 		RT @MSFTDynamics: #CRM2016 unveiled at #Conv15, putting machine learning to work for #custserv:&nbsp;https://t.co/If2xeS0b5I (via @pcworld) http…
// 		<br>
// 		<div>
// 			<span class="info-icon"><i class="material-icons">access_time</i> 1448989389</span>
// 			<span class="info-icon"><i class="material-icons">favorite</i> 1448989389</span>
// 			<span class="info-icon"><i class="material-icons">repeat</i> 1448989389</span>
// 			<a href="" target="_blank"><span class="info-icon"><i class="material-icons">public</i> Read More...</span></a>
// 		</div>
// 	</p>
// </div>


						string = '<div class="tweet-div"><img src="' + temp.user.image_pr + '"><a href="https://www.twitter.com/' + temp.user.handle + '" target="_blank"><span class="text-muted">@' + temp.user.handle + '</span> | ' + temp.user.name + '</a><p>' + temp.text + '<br><div><span class="info-icon"><i class="material-icons">access_time</i> ' + temp.time + '</span><span class="info-icon"><i class="material-icons">favorite</i> ' + temp.favorite_count + '</span><span class="info-icon"><i class="material-icons">repeat</i> ' + temp.retweet_count + '</span><a href="' + temp.tweet_url + '" target="_blank"><span class="info-icon"><i class="material-icons">public</i> Read More...</span></a></div></p></div>';
                	targ.append(string);
                }
            } else {
                targ.html('<p class="error-message">Tweets cannot be displayed right now.</p>');
            }
        },
        beforeSend : function(){
        	//display Loading information
            targ.html('<p class="error-message">Fetching results, please wait...</p>');
        }
    });
}