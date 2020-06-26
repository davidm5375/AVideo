<?php
global $isLive;
$isLive = 1;
$customizedAdvanced = AVideoPlugin::getObjectDataIfEnabled('CustomizeAdvanced');

$objSecure = AVideoPlugin::loadPluginIfEnabled('SecureVideosDirectory');
if (!empty($objSecure)) {
    $objSecure->verifyEmbedSecurity();
}
?>
<!DOCTYPE html>
<html lang="<?php echo $_SESSION['language']; ?>">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="view/img/favicon.ico">
        <title><?php echo $config->getWebSiteTitle(); ?></title>
        <link href="<?php echo $global['webSiteRootURL']; ?>view/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $global['webSiteRootURL']; ?>view/css/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $global['webSiteRootURL']; ?>view/js/video.js/video-js.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $global['webSiteRootURL']; ?>view/js/videojs-contrib-ads/videojs.ads.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo $global['webSiteRootURL']; ?>view/css/player.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo $global['webSiteRootURL']; ?>view/js/jquery-3.5.1.min.js" type="text/javascript"></script>
        <?php
        echo AVideoPlugin::getHeadCode();
        ?>
        <style>
            body {
                padding: 0 !important;
                margin: 0 !important;
                <?php
                if (!empty($customizedAdvanced->embedBackgroundColor)) {
                    echo "background-color: $customizedAdvanced->embedBackgroundColor;";
                }
                ?>

            }
        </style>
    </head>

    <body>
        <div class="embed-responsive  embed-responsive-16by9">
            <video poster="<?php echo $global['webSiteRootURL']; ?>plugin/Live/view/OnAir.jpg" controls
                   class="embed-responsive-item video-js vjs-default-skin vjs-big-play-centered"
                   id="mainVideo" data-setup='{ "aspectRatio": "16:9",  "techorder" : ["flash", "html5"] }'>
                <source src="<?php echo $t['link']; ?>" type='application/x-mpegURL'>
            </video>
        </div>

        <?php
        if (AVideoPlugin::isEnabled("0e225f8e-15e2-43d4-8ff7-0cb07c2a2b3b")) {
            require_once $global['systemRootPath'] . 'plugin/VideoLogoOverlay/VideoLogoOverlay.php';
            $style = VideoLogoOverlay::getStyle();
            $url = VideoLogoOverlay::getLink();
            ?>
            <div style="<?php echo $style; ?>" class="VideoLogoOverlay">
                <a href="<?php echo $url; ?>" target="_blank"> <img src="<?php echo $global['webSiteRootURL']; ?>videos/logoOverlay.png" class="img-responsive col-lg-12 col-md-8 col-sm-7 col-xs-6"></a>
            </div>
        <?php } ?>
        <script src="<?php echo $global['webSiteRootURL']; ?>view/js/video.js/video.min.js" type="text/javascript"></script>
        <?php
        echo AVideoPlugin::afterVideoJS();
        ?>
        <script src="<?php echo $global['webSiteRootURL']; ?>view/js/videojs-contrib-ads/videojs.ads.min.js" type="text/javascript"></script>
        <script src="<?php echo $global['webSiteRootURL']; ?>plugin/Live/view/videojs-contrib-hls.min.js" type="text/javascript"></script>
        <script src="<?php echo $global['webSiteRootURL']; ?>view/js/videojs-persistvolume/videojs.persistvolume.js" type="text/javascript"></script>
        <script>

            $(document).ready(function () {
                if (typeof player === 'undefined') {
                    player = videojs('mainVideo'<?php echo PlayerSkins::getDataSetup(); ?>);
                }
                player.ready(function () {
                    var err = this.error();
                    if (err && err.code) {
                        $('.vjs-error-display').hide();
                        $('#mainVideo').find('.vjs-poster').css({'background-image': 'url(<?php echo $global['webSiteRootURL']; ?>plugin/Live/view/Offline.jpg)'});
<?php
if (!empty($html)) {
    echo "showCountDown();";
}
?>
                    }
<?php
if ($config->getAutoplay()) {
    echo "this.play();";
}
?>

                });
                player.persistvolume({
                    namespace: "AVideo"
                });
            });
        </script>
        <?php
        require_once $global['systemRootPath'] . 'plugin/AVideoPlugin.php';
        echo AVideoPlugin::getFooterCode();
        ?>
    </body>
</html>

<?php
include $global['systemRootPath'] . 'objects/include_end.php';
?>
