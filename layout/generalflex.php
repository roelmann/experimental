<?php

$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$haslogininfo = (empty($PAGE->layout_options['nologininfo']));

$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

$bodyclasses = array();
if ($showsidepre && !$showsidepost) {
    $bodyclasses[] = 'side-pre-only';
} else if ($showsidepost && !$showsidepre) {
    $bodyclasses[] = 'side-post-only';
} else if (!$showsidepost && !$showsidepre) {
    $bodyclasses[] = 'content-only';
}
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}

$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';
if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader = $OUTPUT->course_content_header();
    if (empty($PAGE->layout_options['nocoursefooter'])) {
        $coursecontentfooter = $OUTPUT->course_content_footer();
        $coursefooter = $OUTPUT->course_footer();
    }
}

echo $OUTPUT->doctype() ?>
<html <?php echo $OUTPUT->htmlattributes() ?>>
<head>
    <title><?php echo $PAGE->title ?></title>
    <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
    <?php echo $OUTPUT->standard_head_html() ?>
</head>
<body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join(' ', $bodyclasses)) ?>">
<?php echo $OUTPUT->standard_top_of_body_html() ?>

<div id="page">

    <header>
        <div id="page-header">
            <div id="page-header-wrapper" class="clearfix">
                <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
                <h3>This is currently an experimental theme using the flexbox model. This is supported in Chrome21+, Opera12.1+, Firefox22+ (due out Jun25th 2013). IE10 supports a mixed version of the flexbox model syntaxes.</h3>
                <div class="headermenu">
                    <?php
                        echo $OUTPUT->login_info();
                           if (!empty($PAGE->layout_options['langmenu'])) {
                               echo $OUTPUT->lang_menu();
                           }
                           echo $PAGE->headingmenu;
                    ?>
                </div>
            </div>
        </div>
    </header>

    <?php if ($hascustommenu) { ?>
        <nav id='menu'>
            <div id="custommenu"><?php echo $custommenu; ?></div>
        </nav>
    <?php } ?>

    <?php if (!empty($courseheader)) { ?>
        <div id="course-header"><?php echo $courseheader; ?></div>
    <?php } ?>

    <?php if ($hasnavbar) { ?>
        <nav id='breadcrumb'>
            <div class="navbar clearfix">
                <div class="breadcrumb"><?php echo $OUTPUT->navbar(); ?></div>
                <div class="navbutton"> <?php echo $PAGE->button; ?></div>
            </div>
        </nav>
    <?php } ?>
    
    <div id="page-content">
        <div id='outerwrapper' class='threecolhg'>
            <section class='main'>
                <article>
                    <div id="region-main">
                        <div class="region-content">
                            <?php echo $coursecontentheader; ?>
                            <?php echo $OUTPUT->main_content() ?>
                            <?php echo $coursecontentfooter; ?>
                        </div>
                    </div>
                </article>
            </section>
            
            <?php if ($hassidepre) { ?>
                <aside class='pre'>
                    <div id="region-pre" class="block-region">
                        <div class="region-content">
                            <?php echo $OUTPUT->blocks_for_region('side-pre') ?>
                        </div>
                    </div>
                </aside>
            <?php } ?>
            <?php if ($hassidepost) { ?>
                <aside class='post'>
                    <div id="region-post" class="block-region">
                        <div class="region-content">
                            <?php echo $OUTPUT->blocks_for_region('side-post') ?>
                        </div>
                    </div>
                </aside>
            <?php } ?>
        </div>
    </div>
    <?php if (!empty($coursefooter)) { ?>
        <div id="course-footer"><?php echo $coursefooter; ?></div>
    <?php } ?>

    <?php if ($hasfooter) { ?>
    <footer>
        <div id="page-footer" class="clearfix">
            <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')) ?></p>
            <?php
                echo $OUTPUT->login_info();
                echo $OUTPUT->home_link();
                echo $OUTPUT->standard_footer_html();
            ?>
        </div>
    </footer>
    <?php } ?>

</div> <!-- END #page -->
<?php echo $OUTPUT->standard_end_of_body_html() ?>
</body>
</html>
