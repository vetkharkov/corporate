<li id="li-comment-{{$data['id']}}" class="comment even borGreen">
    <div id="comment-{{$data['id']}}" class="comment-container">
        <div class="comment-author vcard">
            <img alt="" src="https://www.gravatar.com/avatar/{{$data['hash']}}?d=mm&s=75" class="avatar" height="75" width="75" />
            <cite class="fn">{{$data['name']}}</cite>
        </div>

        <div class="comment-meta commentmetadata">
            <div class="intro">
                <div class="commentDate">
                    {{--Дата комментария--}}
                    <a href="#">Дата: Только что!!!</a>
{{--{{ print_r($data) }}--}}
{{--Array ( [name] => qw [email] => qw [site] => qw [text] => qwwwwwwwwww [article_id] => 1 [parent_id] => 1 [id] => 16 [hash] => 006d2143154327a64d86a264aea225f3 )--}}
                </div>
            </div>
            <div class="comment-body">
                <p>{{$data['text']}}</p>
            </div>
        </div>
    </div>
</li>