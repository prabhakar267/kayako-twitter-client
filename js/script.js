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
                        string = '<div class="tweet-div"><img src="' + temp.user.image_pr + '"><a href="https://www.twitter.com/' + temp.user.handle + '" target="_blank"><span class="text-muted">@' + temp.user.handle + '</span> | ' + temp.user.name + '</a><p>' + temp.text + '<br><div><span class="info-icon"><i class="material-icons">access_time</i> ' + temp.time + '</span><span class="info-icon"><i class="material-icons">favorite</i> ' + temp.favorite_count + '</span><span class="info-icon"><i class="material-icons">repeat</i> ' + temp.retweet_count + '</span><a href="' + temp.tweet_url + '" target="_blank"><span class="info-icon"><i class="material-icons">public</i> Read More...</span></a></div></p></div>';
                    targ.append(string);
                }
            } else {
                targ.html('<p class="error-message">Tweets cannot be displayed right now.</p>');
            }
        },
        beforeSend : function(){
            //display Loading information
            targ.html('<img src="http://dkclasses.com/images/loading.gif" class="loader-gif">');
        }
    });
}

$(document).ready(function(){
	showTweets();
});