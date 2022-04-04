<?php


require($_SERVER['DOCUMENT_ROOT'] . '/config/server.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/controllers/logincontroller.php');
require($_SERVER['DOCUMENT_ROOT'].'/config/cloudinaryconfig.php');


$id = $_GET['id'];

$sql = "SELECT * FROM funding WHERE id=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$funding = $result->fetch_assoc();


$sql = "SELECT * FROM funding_details WHERE funding_public=? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $funding['funding_public']);
$stmt->execute();
$result = $stmt->get_result();
$funding_details = $result->fetch_assoc();

// $funding['start_date']
// $funding['end_date']
// $funding['goal']



?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/funding.css">
    <link rel="stylesheet" href="/css/style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <script src="/js/funding.js" defer></script>
    <title><?php echo $funding['funding_name']; ?></title>
</head>
<body>
    <?php
    include($_SERVER['DOCUMENT_ROOT'] . '/components/nav.php');
    include($_SERVER['DOCUMENT_ROOT'] . '/components/googlelogin.php');

    if(0==$funding['verified']){
        echo('<h1 style="margin:auto;text-align: center;">본 펀딩은 승인 대기 중입니다</h1>');
    }else{
    ?>
    
    <section class="section_1">
        <div class="section_1_wrapper">
            <h1 class="funding_title">
                <?php 
                    echo $funding['funding_name']; 
                ?>
            </h1>
            <p class="funding_auther">by 
                <?php 
                    echo $funding['auther']; 
                ?>
            </p>

            <div class="funding_container">
                <div class="funding_img">
                    <?php if (isset($funding['video_url']) && $funding['video_url'] != '') : ?>
                        <div class="iframe_container">
                            <iframe src="https://www.youtube.com/embed/5L6h_MrNvsk" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    <?php else : ?>
                        
                        <img src="<?php echo($cloudinary -> image("/funding/".$id."/main/1.jpg"));?>" alt="">

                    <?php endif; ?>

                </div>
                <div class="funding_info">
                    <div style="background-color: #e6fbff;" class="funding_info_row_container">
                        <div class="funding_info_row">
                            <h1 class="funding_detail" style="color: cornflowerblue;">56</h1>
                            <h1>%</h1>
                            <h1 style="margin-left: auto;"><?php echo number_format($funding['goal']); ?>원</h1>
                        </div>

                        <div id="progress">
                            <div class="progress_bar" style="width: 0;"></div>
                        </div>
                    </div>
                    <div style="background-color: #e6ebff;" class="funding_info_row_container">
                        <div class="funding_info_row">
                        <h1 class="funding_detail">
                        <?php
                        $start_date = $funding['s_date'];
                        $end_date = $funding['e_date'];
                            if (isset($start_date) && isset($end_date)) {
                                if ($end_date < date("Y-m-d")) {
                                    echo ('종료된 펀딩 입니다</h1>');
                                }else{
                                    if ($start_date > date("Y-m-d")) {
                                        $date1 = new DateTime($start_date);
                                        $date2 = new DateTime(date("Y-m-d"));
                                        $interval = $date1->diff($date2);
                                        // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
                                        
                                        // shows the total amount of days (not divided into years, months and days like above)
                                        echo "시작까지 " . $interval->days."일</h1>";
                                    } else {
                                        
                                        $date1 = new DateTime($end_date);
                                        $date2 = new DateTime(date("Y-m-d"));
                                        $interval = $date1->diff($date2);
                                        // echo "difference " . $interval->y . " years, " . $interval->m." months, ".$interval->d." days "; 
                                        
                                        // shows the total amount of days (not divided into years, months and days like above)
                                        echo  $interval->days+1;
                                        echo('</h1><p>일 남음</p>');
                                        
                                    }
                                }
                            }
                        
                        ?>

                            
                        </div>
                        <div class="funding_info_row">
                            <h1 class="funding_detail"><?php ?></h1>
                            <p>원 펀딩</p>
                        </div>
                        <div class="funding_info_row">
                            <h1 class="funding_detail"><?php echo$funding['supporter_count']; ?></h1>
                            <p>명의 서포터</p>
                        </div>
                    </div>
                    <div class="funding_button_wrap">
                        <a href="" class="funding_button">펀딩하기</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="mobile_funding_button_wrap">
        <a href="" class="mobile_funding_button">펀딩하기</a>
    </div>
    <section class="section_2">
        <div class="section_2_wrapper">
            <div class="tab_menu_wrapper">
                <ul class="tab_menu">
                    <li data-tab-target="#story" class="tab_menu_item active">
                        <span style="word-break: keep-all;">스토리</span>
                        <span class="underline"></span>
                    </li>
                    <li data-tab-target="#timeline" class="tab_menu_item">
                        <span style="word-break: keep-all;">타임라인</span>
                        <span class="underline"></span>
                    </li>
                    <li data-tab-target="#comunity" class="tab_menu_item">
                        <span style="word-break: keep-all;">커뮤니티</span>
                        <span class="underline"></span>
                    </li>
                    <li data-tab-target="#reward" class="tab_menu_item">
                        <span style="word-break: keep-all;">리워드</span>
                        <span class="underline"></span>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <section class="section_3">
        <div class="section_3_wrapper">
            <div class="tab_contents" id="tab_contents">
                <div id="story" data-tab-content class="active story">
                    <p>
                        <?php echo $funding_details['funding_details'];?>
                    </p>
                    <img src="/img/s1.jpeg" alt="">
                    <img src="/img/s2.jpeg" alt="">
                    <img src="/img/s3.jpeg" alt="">
                </div>
                <div id="timeline" data-tab-content>
                    <h1>timeline</h1>
                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Omnis similique at quisquam inventore maiores sunt, suscipit animi nulla, reprehenderit quas exercitationem laudantium minima iste et laboriosam, voluptas praesentium deserunt itaque.
                    </p>
                </div>
                <div id="comunity" data-tab-content>
                    <h1>comunity</h1>
                    <p>
                        Lorem ipsum dolor, sit amet consectetur adipisicing elit. Id asperiores similique totam sequi reprehenderit, minima cum delectus praesentium quia est rerum esse magnam, omnis doloremque molestias magni repudiandae, nemo ipsam.
                    </p>
                </div>
            </div>
            <div class="rewards" id="reward" data-tab-content="#reward">
                <div class="reward_item">
                    <div class="reward_item_inner">
                        <div class="reward_item_inner_row">
                            <h1 class="reward_amount">∞ +원 펀딩</h1>
                        </div>
                        <div class="reward_item_inner_row">
                            <h2 class="reward_title">자유펀딩</h2>
                        </div>
                        <div class="reward_item_inner_row">
                            <p class="reward_content">
                                자유로운 후원금액으로 펀딩
                            </p>
                        </div>
                    </div>
                </div>
                <div class="reward_item">
                    <div class="reward_item_inner">
                        <div class="reward_item_inner_row">
                            <h1 class="reward_amount">50,000원 펀딩</h1>
                        </div>
                        <div class="reward_item_inner_row">
                            <h2 class="reward_title">치킨 샐러드</h2>
                        </div>
                        <div class="reward_item_inner_row">
                            <p class="reward_content">
                                피가 같이 주며, 인생의 못하다 오아이스도 따뜻한 봄바람이다. 간에 석가는 무엇이 이것이다. 그러므로 하는 이것은 끝까지 할지니, 이상의 아름다우냐? 그러므로 뭇 광야에서 보이는 끓는다. 인류의 영원히 싹이 그들에게 그들은 끓는다. 할지니, 싸인 설산에서 역사를 위하여, 같으며, 가치를 이것이다. 너의 방황하였으며, 얼음에 없으면, 이상은 굳세게 피는 부패뿐이다. 희망의 뜨고, 위하여 이것이다. 사라지지 물방아 주며, 이상 약동하다. 풀밭에 피가 작고 남는 풀이 그들은 전인 그들에게 운다. 인간은 천지는 트고, 길지 우리의 꾸며 되는 관현악이며, 충분히 것이다.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="reward_item">
                    <div class="reward_item_inner">
                        <div class="reward_item_inner_row">
                            <h1 class="reward_amount">50,000원 펀딩</h1>
                        </div>
                        <div class="reward_item_inner_row">
                            <h2 class="reward_title">치킨 샐러드</h2>
                        </div>
                        <div class="reward_item_inner_row">
                            <p class="reward_content">
                                피가 같이 주며, 인생의 못하다 오아이스도 따뜻한 봄바람이다. 간에 석가는 무엇이 이것이다. 그러므로 하는 이것은 끝까지 할지니, 이상의 아름다우냐? 그러므로 뭇 광야에서 보이는 끓는다. 인류의 영원히 싹이 그들에게 그들은 끓는다. 할지니, 싸인 설산에서 역사를 위하여, 같으며, 가치를 이것이다. 너의 방황하였으며, 얼음에 없으면, 이상은 굳세게 피는 부패뿐이다. 희망의 뜨고, 위하여 이것이다. 사라지지 물방아 주며, 이상 약동하다. 풀밭에 피가 작고 남는 풀이 그들은 전인 그들에게 운다. 인간은 천지는 트고, 길지 우리의 꾸며 되는 관현악이며, 충분히 것이다.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="reward_item">
                    <div class="reward_item_inner">
                        <div class="reward_item_inner_row">
                            <h1 class="reward_amount">50,000원 펀딩</h1>
                        </div>
                        <div class="reward_item_inner_row">
                            <h2 class="reward_title">치킨 샐러드</h2>
                        </div>
                        <div class="reward_item_inner_row">
                            <p class="reward_content">
                                피가 같이 주며, 인생의 못하다 오아이스도 따뜻한 봄바람이다. 간에 석가는 무엇이 이것이다. 그러므로 하는 이것은 끝까지 할지니, 이상의 아름다우냐? 그러므로 뭇 광야에서 보이는 끓는다. 인류의 영원히 싹이 그들에게 그들은 끓는다. 할지니, 싸인 설산에서 역사를 위하여, 같으며, 가치를 이것이다. 너의 방황하였으며, 얼음에 없으면, 이상은 굳세게 피는 부패뿐이다. 희망의 뜨고, 위하여 이것이다. 사라지지 물방아 주며, 이상 약동하다. 풀밭에 피가 작고 남는 풀이 그들은 전인 그들에게 운다. 인간은 천지는 트고, 길지 우리의 꾸며 되는 관현악이며, 충분히 것이다.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="reward_item">
                    <div class="reward_item_inner">
                        <div class="reward_item_inner_row">
                            <h1 class="reward_amount">50,000원 펀딩</h1>
                        </div>
                        <div class="reward_item_inner_row">
                            <h2 class="reward_title">치킨 샐러드</h2>
                        </div>
                        <div class="reward_item_inner_row">
                            <p class="reward_content">
                                피가 같이 주며, 인생의 못하다 오아이스도 따뜻한 봄바람이다. 간에 석가는 무엇이 이것이다. 그러므로 하는 이것은 끝까지 할지니, 이상의 아름다우냐? 그러므로 뭇 광야에서 보이는 끓는다. 인류의 영원히 싹이 그들에게 그들은 끓는다. 할지니, 싸인 설산에서 역사를 위하여, 같으며, 가치를 이것이다. 너의 방황하였으며, 얼음에 없으면, 이상은 굳세게 피는 부패뿐이다. 희망의 뜨고, 위하여 이것이다. 사라지지 물방아 주며, 이상 약동하다. 풀밭에 피가 작고 남는 풀이 그들은 전인 그들에게 운다. 인간은 천지는 트고, 길지 우리의 꾸며 되는 관현악이며, 충분히 것이다.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="reward_item">
                    <div class="reward_item_inner">
                        <div class="reward_item_inner_row">
                            <h1 class="reward_amount">50,000원 펀딩</h1>
                        </div>
                        <div class="reward_item_inner_row">
                            <h2 class="reward_title">치킨 샐러드</h2>
                        </div>
                        <div class="reward_item_inner_row">
                            <p class="reward_content">
                                피가 같이 주며, 인생의 못하다 오아이스도 따뜻한 봄바람이다. 간에 석가는 무엇이 이것이다. 그러므로 하는 이것은 끝까지 할지니, 이상의 아름다우냐? 그러므로 뭇 광야에서 보이는 끓는다. 인류의 영원히 싹이 그들에게 그들은 끓는다. 할지니, 싸인 설산에서 역사를 위하여, 같으며, 가치를 이것이다. 너의 방황하였으며, 얼음에 없으면, 이상은 굳세게 피는 부패뿐이다. 희망의 뜨고, 위하여 이것이다. 사라지지 물방아 주며, 이상 약동하다. 풀밭에 피가 작고 남는 풀이 그들은 전인 그들에게 운다. 인간은 천지는 트고, 길지 우리의 꾸며 되는 관현악이며, 충분히 것이다.
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <?php
    


    include($_SERVER['DOCUMENT_ROOT'] . "/components/footer.php");
     

    ?>

</body>
<?php
}//승인 펀딩 if 
?>

</html>