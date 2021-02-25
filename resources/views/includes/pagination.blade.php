@if ($paginator->hasPages())
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center py-3">
                <li class="page-item 
                @if($paginator->onFirstPage()) disabled @endif"
                >
                    <a class="page-link" href="{{$paginator->previousPageUrl()}}" tabindex="-1">Prev</a>
                </li>
                <?php
                    $num_side_links = 1;

                    $first_item = $paginator->currentPage() - $num_side_links;
                    $last_item = $paginator->currentPage() + $num_side_links;

                    $current_page_list 
                        = range($first_item, $last_item);
                    
                    $mod = 0;

                    if ($first_item < 1) {
                        $mod = 1 - $first_item;
                    } elseif (
                        $last_item > $paginator->lastPage() 
                        && 
                        !(count($current_page_list) > $paginator->lastPage())) {

                        $mod = $paginator->lastPage() - $last_item;
                    }
                ?>
                
                @foreach ($current_page_list as $item)
                    
                    <?php 
                        if ($loop->iteration > $paginator->lastPage()) {
                            break;
                        }

                        $page = $item + $mod;
                    ?> 

                    <li class="page-item 
                    @if($paginator->currentPage() == $page) active @endif"
                    >
                        <a class="page-link" href="{{$paginator->url($page)}}">{{$page}}</a>
                    </li>

                    
                @endforeach

                <li class="page-item
                @if($paginator->currentPage() == $paginator->lastPage()) disabled @endif"
                >
                    <a class="page-link" href="{{$paginator->nextPageUrl()}}">Next</a>
                </li>
            </ul>
        </nav>
    @endif