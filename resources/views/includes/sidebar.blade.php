<aside class="right-sidebar">
        <div class="search-widget">
        <form action="{{ route('index') }}">
                <div class="input-group">
                  <input type="text" name="searchTerm" value="{{ request('searchTerm') }}" class="form-control input-lg" placeholder="Search for...">
                  <span class="input-group-btn">
                    <button class="btn btn-lg btn-default" type="submit">
                        <i class="fa fa-search"></i>
                    </button>
                  </span>
                </div><!-- /input-group -->
            </form>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Categories</h4>
            </div>
            <div class="widget-body">
                <ul class="categories">
                    @if(empty($categories))
                        <li>There are no categories.</li>
                    @else 
                        @foreach($categories as $category)
                            @if($category->posts()->published()->count() > 0)
                                <li>
                                    <a href="{{ route('category.search', ['category' => $category->slug]) }}"><i class="fa fa-angle-right"></i> {{ $category->title }}</a>
                                    <span class="badge pull-right">{{ $category->posts()->published()->count() }}</span>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Popular Posts</h4>
            </div>
            <div class="widget-body">
                <ul class="popular-posts">
                    @if(empty($popularPosts))
                        <li>There are no posts.</li>
                    @else 
                        @foreach($popularPosts as $popular_post)
                            <li>
                                @if($popular_post->image_url)
                                    <div class="post-image">
                                        <a href="{{ route('show.post', ['post'=>$popular_post->slug]) }}">
                                            <img src="{{ $popular_post->image_thumb }}" />
                                        </a>
                                    </div>
                                @endif
                                <div class="post-body">
                                    <h6><a href="{{ route('show.post', ['post'=>$popular_post->slug]) }}">{{ $popular_post->title }}</a></h6>
                                    <div class="post-meta">
                                        <span>{{ $popular_post->date }}</span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Tags</h4>
            </div>
            <div class="widget-body">
                <ul class="tags">
                    @if(empty($tags))
                        <li>There are no tags.</li>
                    @else 
                        @foreach($tags as $tag)
                            <li><a href="{{ route('tag.search', ['tag' => $tag->slug]) }}">{{ $tag->name }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>

        <div class="widget">
            <div class="widget-heading">
                <h4>Archives</h4>
            </div>
            <div class="widget-body">
                <ul class="categories">
                    @foreach ($archives as $archive)
                        <li>
                            <a href="{{ route('index', ['month' => $archive->month, 'year' => $archive->year]) }}">{{ $archive->month . " " . $archive->year }}</a>
                            <span class="badge pull-right">{{ $archive->post_count }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </aside>