@if(isset($ArticleList))

    @foreach($ArticleList as $ArticleData)

    <div class="col article-section border">
        <!-- onclick="javascript: location.href='edit-article/{{ $ArticleData->article_id }}'" -->
        <div class="row">
            <div class="col-2">
            @if(!$ArticleData->Author->user_picture)
                <img src="/images/icon/default.png" class="w-100 img-thumbnail">
            @else
                <img src="{{ URL::asset($ArticleData->Author->user_picture) }}" class="w-100 img-thumbnail">
            @endif
            </div>
            <div class="col-10 article-title">
                <div class="row">
                    <div class="position-relative">
                        <div class="col">
                            <a href="/user/{{ $ArticleData->Author->id }}">{{ $ArticleData->Author->nickname }}</a>
                        </div>
                        @if($ArticleData->Author->id == Auth::id())
                        <div class="position-absolute top-0 end-0 me-3">
                            <button class="btn btn-sm btn-outline-dark" onclick="location.href='/user/edit-article/{{ $ArticleData->article_id }}'">修改</button>
                        </div>
                        @endif
                    </div>
                </div>
                
                <p class="h3">{{ $ArticleData->article_title }}</p>
                <div class="col article-content mt-3 text-break overflow-hidden" style="max-height: 76px;">
                    <p>{!! nl2br(e($ArticleData->article_content)) !!}</p>
                </div>
            </div>            
        </div>

        <hr class="less-hr">
        <div class="row">
            <small class="text-black-50">{{ $ArticleData->created_at }}</small>
            @if(count($ArticleData->commits)>0)
            
                <a href="#" data-bs-toggle="collapse" data-bs-target="#articleComment_{{ $ArticleData->article_id }}" aria-expanded="false" aria-controls="articleComment_{{ $ArticleData->article_id }}">查看回應</a>
        
            @else

                <small class="text-muted">目前尚無回應</small>

            @endif
        </div>
        @if(auth::check())
        <div class="card card-body mb-2">
            <div class="row">
                <div class="col-10">
                    <input type="text" name='commentText_{{ $ArticleData->article_id }}' class="form-control">
                </div>
                <div class="col-2">
                    <input type="button" name='CommentBtn_{{ $ArticleData->article_id }}' class="btn btn-primary" value="回應">
                </div>
            </div>
        </div>
        @endif
        <div class="collapse" id="articleComment_{{ $ArticleData->article_id }}">

            @foreach($ArticleData->commits as $Commit)
            <div class="card card-body">
                <div class="row">
                    <div class="col-2">
                        <img src="{{URL::asset($Commit->commit_user->user_picture)}}" class="w-100 img-thumbnail">
                    </div>
                    <div class="col-10">
                        <strong>
                            <a href="/user/{{ $Commit->commit_user->id }}">{{ $Commit->commit_user->nickname }}</a>
                        </strong>
                        <small class="fw-light text-black-50 ms-1">{{ $Commit->created_at }}</small>
                        <div>{!! nl2br(e($Commit->commit_content)) !!}</div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>

    @endforeach

    <script>
        $("input[name^='CommentBtn_']").click(function(){
            let commitArticleID = $(this).attr('name').replace('CommentBtn_', '');
            let commentContent  = $("input[name='commentText_" + commitArticleID + "']").val().trim();
            
            if(!commentContent){
                alert('請先輸入留言!');
                $("input[name='commentText_" + commitArticleID + "']").focus();
                return false;
            }

            $.ajax({
                url     : '/writeComment/' + commitArticleID,
                data    : {'commentContent' : commentContent},
                dataType: 'json',
                type    : 'POST',
                headers : {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success : function(response){
                    let CommentFields = generateCommentFields(commentContent);
                    if(response.responseMessage=='建立成功'){
                        $("input[name='commentText_" + commitArticleID + "']").val('');
                        $("#articleComment_" + commitArticleID).append(CommentFields);
                        $("#articleComment_" + commitArticleID).slideDown();
                    }
                },
                error   : function(XMLHttpRequest){
                    if(XMLHttpRequest.status=='401'){
                        alert('請先登入後重新操作!');
                    }else if(XMLHttpRequest.status=='400'){
                        alert('操作錯誤!');
                    }else if(XMLHttpRequest.status=='422'){
                        alert('操作逾時!');
                        location.href = location.href;
                    }else{
                        console.log(XMLHttpRequest);
                    }
                }
            });
        })

        function generateCommentFields(comment = '')
        {
            let selfAvator    = '{{ Auth::user() ? Auth::user()->user_picture : "" }}';
            let userName      = '{{ Auth::user() ? Auth::user()->nickname : "" }}';
            let currentTime   = new Date();
            let currentHour   = currentTime.getHours();
            let currentMinute = currentTime.getMinutes();
            let currentSecond = currentTime.getSeconds();
            let timeFormat    = currentHour + ':' + currentMinute + ':' + currentSecond;
            return '' +
            '<div class="card card-body">' + 
                '<div class="row">' + 
                    '<div class="col-2">' + 
                        '<img src="' + selfAvator + '" class="w-100 img-thumbnail">' + 
                    '</div>' + 
                    '<div class="col-10">' + 
                        '<strong>' + 
                            '<a href="/user/{{ Auth::id() }}">' + userName + '</a>' + 
                        '</strong>'+
                        '<small class="fw-light text-black-50 ms-1">' + timeFormat + '</small>' + 
                        '<div>' + comment + '</div>' + 
                    '</div>' + 
                '</div>' + 
            '</div>';
        }

    </script>

@endif