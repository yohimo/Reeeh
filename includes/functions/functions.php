<?php
function Feed($search, $limit=10, $start, $type_user, $user_work, $city, $country)
{
    $User = $_SESSION['user'];
    /*
    $search = func_get_arg(0);
    $search = strip_tags($search);
    $search = addslashes($search);
    */
    //var_dump(func_num_args());
    $search =  '';
    $start = func_get_arg(2);
    $UserType = 0;//func_get_arg(3);
    $Work = 0;//func_get_arg(4);
    $Work = 0;//str_replace('job','',$Work);
    $Work = 0;//str_replace('edu','',$Work);
    $City = 0;//func_get_arg(5);
    $Country = 0;//func_get_arg(6);



    if(func_num_args() == 8 || func_num_args() == 9) {
        if(func_get_arg(7) > 0)
        {
            $UserID = intval(func_get_arg(7));
            $UserSQL = " and id_user = $UserID ";    
        }else{
            $UserSQL = '';    
        }
    }else{
        $UserSQL = '';
    }

    if(func_num_args() == 9) {
        if(func_get_arg(8) > 0)
        {
            $LastArticle = intval(func_get_arg(8));
            $LastArticleSQL = " and id > $LastArticle ";    
        }else{
            $LastArticleSQL = '';    
        }
    }else{
        $LastArticleSQL = '';
    }

    //echo $UserSQL;

    if (file_exists('includes/classes/db/db.class.php')) {
        require_once 'includes/classes/db/db.class.php';
        require_once 'includes/classes/upload/upload.php';
        require_once 'includes/classes/security/security.class.php'; 
        require_once 'includes/classes/comments/comments.class.php';
        require_once 'includes/classes/likes/likes.class.php';
        require_once 'includes/classes/dislikes/dislikes.class.php';
        require_once 'includes/classes/seens/seens.class.php';
        require_once 'includes/classes/users/users.class.php';
        require_once 'includes/classes/modules/modules.class.php';
    }elseif(file_exists('../includes/classes/db/db.class.php'))
    {
        require_once '../includes/classes/db/db.class.php';
        require_once '../includes/classes/upload/upload.php';
        require_once '../includes/classes/security/security.class.php';
        require_once '../includes/classes/comments/comments.class.php';
        require_once '../includes/classes/likes/likes.class.php';
        require_once '../includes/classes/dislikes/dislikes.class.php';
        require_once '../includes/classes/seens/seens.class.php';
        require_once '../includes/classes/users/users.class.php';
        require_once '../includes/classes/modules/modules.class.php';
    }elseif(file_exists('../../includes/classes/db/db.class.php'))
    {

        require_once '../../includes/classes/db/db.class.php';
        require_once '../../includes/classes/upload/upload.php';
        require_once '../../includes/classes/security/security.class.php';
        require_once '../../includes/classes/comments/comments.class.php';
        require_once '../../includes/classes/likes/likes.class.php';
        require_once '../../includes/classes/dislikes/dislikes.class.php';
        require_once '../../includes/classes/seens/seens.class.php';
        require_once '../../includes/classes/users/users.class.php';
        require_once '../../includes/classes/modules/modules.class.php';
    }else{
        die('file not found');
    }
        $DB = Database::getInstance();
        $Security = new Security();
        $DB = Database::getInstance();
        $Comments  = new Comments();
        $Likes  = new Likes();
        $Users = new user();
        $Dislikes  = new Dislikes();
        $Seens   = new Seens();
        $SQL_Search = 'where 1=1';
        /*
        if(!empty($category1))
        {
            $SQL_Search .= " and id_pc1 = $category1 "; 
        }
        */
        if(!empty($LastArticleSQL))
        {
            $SQL_Search .= $LastArticleSQL;
        }
        if($UserSQL != '')
        {
            $SQL_Search .= $UserSQL;
        }else{
            if(isset($search) && $search != '')
            {
                $SQL_Search .= " and subject like '%$search%' "; 
            }

            if(isset($UserType) && $UserType > 0)
            {
                $SQL_Search .= " and id_user_type = $UserType "; 
            }

            if(isset($Work) && $Work > 0)
            {
                $SQL_Search .= " and id_work = $Work "; 
            }elseif(isset($Work) && $Work == 'me')
            {
                /*
                if($Users->getUserType($User) == 1)
                {
                    $Work = $Users->getUserJobId($User);
                    $SQL_Search .= " and id_work = $Work "; 
                }else{
                    $Work = $Users->getUserEducationId($User);
                    $SQL_Search .= " and id_work = $Work "; 
                }
                */
            }

            if(!empty($Country) && $Country > 0)
            {
                $SQL_Search .= " and id_country = $Country "; 
            }elseif(isset($Country) && $Country === 'me')
            {
                $Country = $Users->getUserCountryId($User);
                $SQL_Search .= " and id_country = $Country "; 
            }
            /*
            else{
                $City = '';
            }
            */

            if(!empty($City) && $City > 0)
            {
                //echo 'city sitted';
                $SQL_Search .= " and id_city = $City "; 
            }elseif(isset($City) && $City === 'me')
            {
                //echo 'city me';
                $City = $Users->getUserCityId($User);
                $SQL_Search .= " and id_city = $City "; 
            }    
        }
        

        


        if($start > 0)
        {
            $sql = "select * from posts $SQL_Search or sticked = 1 order by id desc limit $start,$limit";    
        }else{
            $sql = "select * from posts $SQL_Search or sticked = 1 order by id desc limit $start,$limit";    
        }
        //die($sql);
        //echo('<div style="display:none">'.$sql.'</div>');
        $query3 = $DB->query($sql);
        $query3->execute();
        
        function isJson($string) {
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        }
                       
        if ($query3->rowCount() > 0) {
            while ($result = $query3->fetch(PDO::FETCH_ASSOC)) {
                $PostID = $result['id'];
                $UserID = $result['id_user'];
                $CDate = $result['cdate'];

                $LastArticle = $PostID;
                //echo $UserID;
                //die();

                $full_name = $Users->getUserFirstLastName($UserID);
                $JobUser = $Users->getUserJob($UserID);
                $CityUser = $Users->getUserCity($UserID);
                $CountryUser = $Users->getUserCountry($UserID);
                $EduUser = $Users->getUserEducation($UserID);
                $UserType = $Users->getUserType($UserID);
                
                ?>
                <article class="article" article-id="<?php echo $PostID; ?>">
                    <a href="Profile/<?php echo $UserID;?>" style="float:right">
                        <img src="<?php echo $Users->getDefaultPicture($UserID);;?>" style="margin-top: -40px;;width: 50px;height: 50px;border-radius: 25px" title="<?php echo $full_name; ?>">
                    </a>
                            <?php
                             if (!empty($result['subject'])) {
                                echo '<h3><a class="preview" href="#Preview/'.$PostID.'" data-link="Preview/'.$PostID.'">';            
                                echo $result['subject'];
                                echo '</span></a></h3>';
                            }
                            ?>
                         
    

                        <?php
                       
                        $article = 0;
                        $max_articles = 2;
                        $text = $result['text'];
                        $text = stripslashes($result['text']);
                        if(is_array(json_decode($text)))
                        {
                                $text = json_decode($text);
                                foreach($text as $textElement)
                                {
                                    if($article < $max_articles)
                                    {
                                        foreach($textElement as $element)
                                        {
                                            if(isset($textElement->text))
                                            {
                                                echo '<p>'.$textElement->text.'</p>';
                                            }
                                            if(isset($textElement->image))
                                            {
                                                echo '<img src="'.$textElement->image.'">';
                                            }
                                            if(isset($textElement->link))
                                            {
                                                echo '<a href="http://'.$textElement->link.'" target="blank">'.$textElement->link.'</a>';
                                            }
                                        }
                                    }
                                    $article++;
                                }
                            
                        }else{
                            //echo 'not good format';
                        }
                        ?>
                    <div class="controls-post">
                        <a class="Likes like" class="Like" data-id="<?php echo $PostID; ?>" data-type="posts">
                            <span class="like" id="Post<?php echo $PostID; ?>Like"> <?php echo $Likes->count('Posts', $PostID); ?> </span>
                            <span class="">أعجبني</span>
                        </a>
                        
                        <a class="Dislikes dislike" class="Dislike" data-id="<?php echo $PostID; ?>" data-type="posts">
                            <span class="dislike" id="Post<?php echo $PostID; ?>Dislike"><?php echo $Dislikes->count('Posts', $PostID); ?></span>
                            <span class="">لم يعجبني</span>
                        </a>
                        
                        <a class="Shares hide">
                            <span class="">5343</span>
                            <span class="">شارك</span>
                        </a>

                        <a class="fleft Report hide">بلغ عن المقال</a>
                    </div>
            
                </article>
                <?php
            }
            //show the loading 10
            $startFrom = $start + $limit;
            echo '<div id="load-more" style="text-align: center;cursor: pointer" data-last="'.$startFrom.'">اظهر منشورات اقدم</div>';
?>
<script language="javascript" src="js/facebox/facebox.js"></script>

<script>
$().ready(function(){
    $("#load-more").click(function(){
        var start = $(this).attr('data-last');
        var userType = $("#search_user_type").val();
        var Work = $("#search_user_work").val();
        var Country = $("#search_country").val();
        var City = $("#search_city").val();
        var search = '';
        var LastArticle = $('#home-center-side article:first').attr('article-id');
        //console.log('load 10');
        //var LastArticle = $(".home-post:first").attr('article-id');
        $(this).remove();
        $.post("ajax/feed.php", {source : 'load10', search:search,start: start,search_user_type:userType,search_user_work:Work,search_country:Country,search_city:City, LastArticle:LastArticle},function(data){
            $("#content article:last").after(data);
        });
    });
//////7

    (function($) {

     var setupFeedPreview = $.fn.setupFeedPreview;

        $.fn.setupFeedPreview = function(options) {
            if(typeof options === "object") {
                options = $.extend(true, options, {
                    // locale
                    isRTL: false,
                    firstDay: 1,
                    // some more options
                });
            }
            $('#content article').find('a.preview').each(function(){
                if ($(this).hasClass("preview"))
                {
                    $(this).click(function(){
                        //$(this).addClass('preview');
                        $(this).addClass('inPreview');
                        var DataLinkFeed = $(this).attr("data-link"); //Get entry ID
                        $.facebox({ ajax: DataLinkFeed });

                    })
                }
            });

            
            $("#home-center-side article .home-post-header").find("a.white_a").each(function(){
                if (!$(this).hasClass("preview"))
                {
                    $(this).click(function(){
                        $(this).addClass('preview');
                        $(this).addClass('inPreview');
                        var DataLinkFeed = $(this).attr("data-link"); //Get entry ID
                        $.facebox({ ajax: DataLinkFeed });

                    })
                }
            });


            return false;
        }


    })(jQuery);
    $().setupFeedPreview();



////
})
</script>
<?php
    } else {
        echo '';
    }
}


function GoHome()
{
    header("location:".WebSite);
}

function ProfileUpdate()
{
    die('<script>window.location = "Step3";</script>');
}

function Subscribe()
{
    //require_once 'includes/plugins/users/subscribe/subscribe.php';
    //die();
    die('<script>window.location = "Login";</script>');
}
function Connected()
{
    if(!isset($_SESSION['user']))
    {
        if((isset($_GET['Module']) && $_GET['Module'] != 'Login') || !isset($_GET['Module']))
        {
            //die(WebSite);
            header("location:".WebSite.'Login');
        }
    }else{
        return true;
    }
}

function Liste($table,$fieldid,$field,$where,$selected)
{
    $DB = Database::getInstance();
    //$Table
    //$Fieldid
    //$Field
    //$Where
    $sql = "select $fieldid,$field from $table where $where";
//    echo '<option>'.$sql.'</option>';
    $sth = $DB->query($sql);
    $sth->execute();
    while($row = $sth->fetch(PDO::FETCH_ASSOC))
    {
        if(isset($selected) && is_numeric($selected))
        {
            if($row[$fieldid] == $selected)
            {
                echo '<option value="'.$row[$fieldid].'" selected="selected">'.stripslashes($row[$field]).'</option>';
            }else{
                echo '<option value="'.$row[$fieldid].'">'.stripslashes($row[$field]).'</option>';
            }
        }else{
            echo '<option value="'.$row[$fieldid].'">'.stripslashes($row[$field]).'</option>';
        }

    }
    echo 'ok';
}
function user(){
    echo $_SESSION['user'];
}
function confirm_login()
{
    if(!isset($_SESSION['user_id']))
    {
        redirect_to("login.php");
    }
}

?>