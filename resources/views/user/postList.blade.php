<?php $acc = -1 ?>
            @foreach($usersPost as $post)
            <?php $acc++ ?>
            <div id="accordion">
                <div class="card" style="border-color: #FFB75E;">
                    <div class="card-header text-white" style="background-color: #FFB75E;">
                            {{ $post->user->first_name.' '.$post->user->last_name }}
                            <a class="pl-2" style="float: right;" href="{{ url('post/'.$post['post_id'].'/edit') }}"> 
                            <i class="far fa-edit" style="color: white;"></i>
                            </a>
                            <a class="pl-2" style="float: right;" href="{{ url('post/'.$post['post_id'].'/delete') }}">
                            <i class="far fa-trash-alt" style="color: white;"></i>
                            </a>
                            <?php $var = 0 ?>
                            @foreach($post->comments as $check)
                                @if(!empty($check->comment_content))
                                    <?php $var++ ?>
                                @endif
                            @endforeach
                            @if($var !=  0)
                            <a style="float: right" href="{{ url('post/'. $post->post_id .'/view') }}"><i class="fas fa-comments" style="color: white;"></i></a>
                            @endif
                    </div>
                    <div class="card-body">
                        <p class="card-text">
                            {{ $post->post_content }}
                        </p>
                        @if(is_null($post->usersPostFeeling))
                            <span></span>
                        @else
                        Feeling <span style="font-weight: bold; color: red;">{{ $post->usersPostFeeling->postFeeling->post_feeling_name }}</span>
                        @endif
                    </div>
                    </div>

                    <div class="mw-card card">
                        <div class="mw-cd-h card-header" id="heading{{ $acc }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link text-white" data-toggle="collapse" data-target="#collapse{{ $acc }}" aria-expanded="true" aria-controls="collapse{{ $acc }}">
                            Media Wall
                            </button>
                        </h5>
                        </div>

                        <div id="collapse{{ $acc }}" class="collapse" aria-labelledby="heading{{ $acc }}" data-parent="#accordion">
                        @foreach($quotes as $row)
                            @foreach($row as $details => $value)
                            @if($post->post_id == $value->post_id)
                                <div class="card-body">
                                    <h6 class="card-title" style="font-weight: bold">{{ $value->quote->quoteText }}</h6>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $value->quote->quoteAuthor }}</h6>
                                </div>
                            @endif
                            @endforeach
                        @endforeach
                        
                        @foreach($comp as $row)
                            @if($post->post_id == $row['post_id'])
                            @foreach($videos as $row1)
                                @foreach($row1 as $value)
                                @if($row['videoID'] == $value['videoID'])
                                <div class="card-body">
                                    <iframe class="w-100" height="315" src="https://www.youtube.com/embed/{{ $value->videos->videoApi_id }}"></iframe>
                                </div>
                                @endif
                                @endforeach
                            @endforeach
                            @endif
                        @endforeach
                        </div>
                    </div>
                    <?php $var = 0 ?>
                    @foreach($post->comments as $check)
                        @if(!empty($check->comment_content))
                            <?php $var++ ?>
                        @endif
                    @endforeach
                    @if($var !=  0)
                    <?php $acc++ ?>
                    <div class="mw-card card">
                        <div class="mw-cd-h card-header" id="heading{{ $acc }}">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed text-white" data-toggle="collapse" data-target="#collapse{{ $acc }}" aria-expanded="false" aria-controls="collapse{{ $acc }}">
                            Comments
                            </button>
                        </h5>
                        </div>
                        <div id="collapse{{ $acc }}" class="collapse" aria-labelledby="heading{{ $acc }}" data-parent="#accordion">
                            @foreach($post->comments as $com)
                                <div class="card-body">
                                    <h6 class="card-title" style="font-weight: bold">{{ $com->user->first_name.' '.$com->user->last_name }}</h6>
                                    <p class="card-text">{{ $com->comment_content }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                <br>
            @endforeach