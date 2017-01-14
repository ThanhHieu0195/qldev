<?php
require_once '../part/common_start_page.php';
require_once '../models/news.php';

// sanitize post value
$group_id = $_POST ['group_id'];
$group_number = filter_var ( $_POST ["group_no"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH );
$items_per_group = intval ( $_POST ['items_per_group'] );
$keyword = $_POST ['key_word'];

// throw HTTP error if group number is not valid
if (! is_numeric ( $group_number )) {
    header ( 'HTTP/1.1 500 Invalid number!' );
    exit ();
}

// get current starting point of records
$position = ($group_number * $items_per_group);

// Limit our results within a specified range.
$model = new news ();
$results = $model->list_news ( $group_id, $position, $items_per_group, $keyword );

if (is_array ( $results )) {
    $count = count ( $results );
    //debug ( $count );
    $rows_num = ceil ( $count / 2 );
    //debug ( $rows_num );
    
    for($i = 0; $i < $rows_num; $i ++) {
        echo "<tr>";
        
        $j = $i * 2;
        if ($j < $count) {
            $row = $results [$j];
            $createdate = dbtime_2_systime ( $row ['last_modified'], 'H:i:s - d/m/Y' );
            
            echo "  <td valign='top' width='50%' class='article_column'>
                    <div class='contentpaneopen'>
                        <h2 class='contentheading'>
                            <a
                                href='../news_management/news-detail.php?i={$row['news_id']}'
                                class='contentpagetitle'> 
                                    <img src='../resources/images/bookmark.png' alt='' /> 
                                    {$row['title']}
                            </a>
                        </h2>
                        <div class='article-toolswrap'>
                            <div class='article-tools clearfix'>
                                <div class='article-meta'>
                                    <span class='createdate'> Cập nhật {$createdate} </span>
                                </div>
                            </div>
                        </div>
                        <div class='article-content'>
                            <p>{$row['summary']}</p>
                        </div>
                        <a
                            href='../news_management/news-detail.php?i={$row['news_id']}'
                            title='{$row['title']}'
                            class='readon'> Đọc thêm... 
                        </a>
                    </div>
                    <span class='article_separator'>&nbsp;</span>
                </td>";
        }
        
        $j = $i * 2 + 1;
        if ($j < $count) {
            $row = $results [$j];
            $createdate = dbtime_2_systime ( $row ['last_modified'], 'H:i:s - d/m/Y' );
        
            echo "  <td valign='top' width='50%' class='article_column'>
                    <div class='contentpaneopen'>
                        <h2 class='contentheading'>
                            <a
                                href='../news_management/news-detail.php?i={$row['news_id']}'
                                class='contentpagetitle'> 
                                    <img src='../resources/images/bookmark.png' alt='' /> 
                                    {$row['title']}
                            </a>
                        </h2>
                        <div class='article-toolswrap'>
                            <div class='article-tools clearfix'>
                                <div class='article-meta'>
                                    <span class='createdate'> Cập nhật {$createdate} </span>
                                </div>
                            </div>
                        </div>
                        <div class='article-content'>
                            <p>{$row['summary']}</p>
                        </div>
                        <a
                            href='../news_management/news-detail.php?i={$row['news_id']}'
                            title='{$row['title']}'
                            class='readon'> Đọc thêm... 
                        </a>
                    </div>
                    <span class='article_separator'>&nbsp;</span>
                </td>";
        }
        
        echo "</tr>";
    }
}

require_once '../part/common_end_page.php';
?>