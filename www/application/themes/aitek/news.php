<?php
defined('C5_EXECUTE') or die("Access Denied.");
$this->inc('elements/header.php'); ?>

<main class="news-page py-5" id="main-content">
  <?php
  if($c->getAttribute('main_image')) {
    $mainImage = $c->getAttribute('main_image');
    $mainImage = $mainImage->getURL(); 
  } else {
    $mainImage = '';
  }

  if($c->getCollectionName()) {
    $title = $c->getCollectionName();
  }

  if($c->getCollectionDescription()) {
    $description = $c->getCollectionDescription();
  }

  if($c->getCollectionDatePublic()) {
    $date = $c->getCollectionDatePublicObject()->format('j.n.Y');

    $language = \Localization::activeLanguage();
            
    if($language == "en") {
        $date = $c->getCollectionDatePublicObject()->format('j F Y');
    }
  }

  if($c->getAttribute('news_author')) {
    $author = $c->getAttribute('news_author');
  }
  if($c->getAttribute('author_title')) {
    $authorTitle = $c->getAttribute('author_title');
  }
  if($c->getAttribute('author_avatar')) {
    $authorAvatar = $c->getAttribute('author_avatar');
    $authorAvatar = $authorAvatar->getURL(); 
  } else {
    $authorAvatar = '';
  }
  if($c->getAttribute('author_description')) {
    $authorDesc = $c->getAttribute('author_description');
  }

  if($c->getAttribute('news_author2')) {
    $author2 = $c->getAttribute('news_author2');
  }
  if($c->getAttribute('author_title2')) {
    $authorTitle2 = $c->getAttribute('author_title2');
  }
  if($c->getAttribute('author_avatar2')) {
    $authorAvatar2 = $c->getAttribute('author_avatar2');
    $authorAvatar2 = $authorAvatar2->getURL(); 
  } else {
    $authorAvatar2 = '';
  }
  if($c->getAttribute('author_description2')) {
    $authorDesc2 = $c->getAttribute('author_description2');
  }

  $topicArr = array();
  $itemTopics = '';
  if($c->getAttribute('news_category')) {
    $topics = $c->getAttribute('news_category');

    if ($topics) {
      foreach ($topics as $topic) {
        $topicArr[] = $topic->getTreeNodeDisplayName();
      }
    }

    $itemTopics = implode(', ', $topicArr);
  }
  ?>
  <div class="news-wrapper">
    <div class="news-content">

      <div class="row">
        <div class="col-md-6">
          <div class="news-info mb-4">
            <span class="news-date"><?php 
              echo $date; 
            ?></span>
            <?php if($author ?? ""):?>
              <span class="news-info-separator">|</span>
              <span class="news-author"><?php echo $author; ?></span>
            <?php endif;?>
             <?php if($author2 ?? ""):?>
              <span class="news-info-separator">|</span>
              <span class="news-author"><?php echo $author2; ?></span>
            <?php endif;?>
            <?php if(count($topicArr) > 0 && $itemTopics):?>
              <span class="news-info-separator">|</span>
              <span class="news-categories"><?php echo $itemTopics; ?></span>
            <?php endif;?>
          </div>
          <div class="news-title">
            <h1><?php
              if ($title ?? "") {
                echo $title; 
              }
             ?></h1>
          </div>
          <p class="ingress"><?php 
            if ($description ?? "") {
              echo $description; 
            }
          ?></p>
          <?php
          $a = new Area('Main Top');
          $a->display($c);
          ?>
        </div>
        <div class="col-md-6">
          <div class="news-image-wrapper mb-4 position-relative">
            <?php if($mainImage): ?>
              <img src="<?php echo $mainImage; ?>" height="450" width="500" class="lazyload news-image" alt="<?php echo $title; ?>">
            <?php else: ?>
              <div class="news-image-placeholder"></div>
            <?php endif;?>
            <div class="accent-border position-absolute bottom-0"></div>
          </div>
        </div>
      </div>

      <div class="row mt-5 news-content-border">
        <div class="news-main-content">
          <?php
          $a = new Area('Main');
          $a->display($c);
          ?>

          <?php if($author ?? ""): ?>
            <div class="row news-author">
              <div class="news-author-avatar col-sm-4 col-lg-3">
                <?php if($authorAvatar): ?>
                  <img src="<?php echo $authorAvatar; ?>" height="150px" class="lazyload news-avatar" alt="<?php echo $author; ?>">
                <?php else: ?>
                  <div class="news-author-avatar-placeholder"></div>
                <?php endif;?>
              </div>
              <div class="news-author-text col-sm-8 col-lg-9">
                <?php if($author): ?>
                  <div class="news-author-name"><?php echo $author;?></div>
                <?php endif;?>
                <?php if($authorTitle ?? ""): ?>
                  <div class="news-author-title"><?php echo $authorTitle;?></div>
                <?php endif;?>
                <?php if($authorDesc ?? ""): ?>
                  <div class="news-author-description"><?php echo $authorDesc;?></div>
                <?php endif;?>
              </div>
            </div>
          <?php endif;?>

          <?php if($author2 ?? ""): ?>
            <div class="row news-author">
              <div class="news-author-avatar col-sm-4 col-lg-3">
                <?php if($authorAvatar2): ?>
                  <img src="<?php echo $authorAvatar2; ?>" height="150px" class="lazyload news-avatar" alt="<?php echo $author2; ?>">
                <?php else: ?>
                  <div class="news-author-avatar-placeholder"></div>
                <?php endif;?>
              </div>
              <div class="news-author-text col-sm-8 col-lg-9">
                <?php if($author2): ?>
                  <div class="news-author-name"><?php echo $author2;?></div>
                <?php endif;?>
                <?php if($authorTitle2 ?? ""): ?>
                  <div class="news-author-title"><?php echo $authorTitle2;?></div>
                <?php endif;?>
                <?php if($authorDesc2 ?? ""): ?>
                  <div class="news-author-description"><?php echo $authorDesc2;?></div>
                <?php endif;?>
              </div>
            </div>
          <?php endif;?>

        </div>
      </div>
    </div>
  </div>
  <div class="news-read-more-list">
    <div class="">
      <div class="row">
        <div class="col-sm-12">
          <?php
          $a = new GlobalArea('News Read More');
          $a->display($c);
          ?>
        </div>
      </div>
    </div>
  </div>
</main>

<?php
$site = Site::getSite();
if($site->getAttribute('site_logo')) {
  $siteLogo = $site->getAttribute('site_logo')->getURL();
} else {
  $siteLogo = '';
}
$schemaDate = $c->getCollectionDatePublicObject()->format('Y-m-d');
$pageUrl = $c->getCollectionLink();
$main_image = "";
$title = "";

$schema = [
  "@context" => "https://schema.org",
  "@type" => "Article",
  "mainEntityOfPage" => [
    "@type" => "WebPage",
    "@id" => $pageUrl,
  ],
  "headline" => $title,
  "image" => [
    "@type" => "ImageObject",
    "url" => $main_image,
  ],
  //"author" => [
  //  "@type" => "Person",
  //  "name" => $userName,
  //],
  "publisher" => [
    "@type" => "Organization",
    "name" => Config::get('concrete.site'),
    "logo" => [
      "@type" => "ImageObject",
      "url" => $siteLogo,
    ]
  ],
  "datePublished" => $schemaDate
]
?>

<script type="application/ld+json">
  <?php echo json_encode($schema); ?>
</script>

<?php  $this->inc('elements/footer.php'); ?>
