<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Richard Oelmann's experimental theme, 
 * an extension of the Moodle Core simple theme which builds on bootstrap as a parent
 * For full information about creating Moodle themes, see:
 * http://docs.moodle.org/dev/Themes_2.0
 *
 * @package   Moodle experimental theme
 * @copyright 2013 Moodle, moodle.org
 * @copyright 2013 Richard Oelmann, editcons.net
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/* Create section variables for layout options*/
$hasheading = ($PAGE->heading);
$hasnavbar = (empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar());
$hasfooter = (empty($PAGE->layout_options['nofooter']));
$hasheader = (empty($PAGE->layout_options['noheader']));

$hassidepre = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-pre', $OUTPUT));
$hassidepost = (empty($PAGE->layout_options['noblocks']) && $PAGE->blocks->region_has_content('side-post', $OUTPUT));
$showsidepre = ($hassidepre && !$PAGE->blocks->region_completely_docked('side-pre', $OUTPUT));
$showsidepost = ($hassidepost && !$PAGE->blocks->region_completely_docked('side-post', $OUTPUT));

$haslogininfo = (empty($PAGE->layout_options['nologininfo']));
/* Create variables for settings options */
$hasfootnote = (!empty($PAGE->theme->settings->footnote));

/* Create variable for custom menu */
$custommenu = $OUTPUT->custom_menu();
$hascustommenu = (empty($PAGE->layout_options['nocustommenu']) && !empty($custommenu));

/* Create variables for course header and footer */
$courseheader = $coursecontentheader = $coursecontentfooter = $coursefooter = '';
if (empty($PAGE->layout_options['nocourseheaderfooter'])) {
    $courseheader = $OUTPUT->course_header();
    $coursecontentheader = $OUTPUT->course_content_header();
    if (empty($PAGE->layout_options['nocoursefooter'])) {
        $coursecontentfooter = $OUTPUT->course_content_footer();
        $coursefooter = $OUTPUT->course_footer();
    }
}

/* Create layout variable for bodyclass */
$layout = 'pre-and-post';
if ($showsidepre && !$showsidepost) {
    if (!right_to_left()) {
        $layout = 'side-pre-only';
    } else {
        $layout = 'side-post-only';
    }
} else if ($showsidepost && !$showsidepre) {
    if (!right_to_left()) {
        $layout = 'side-post-only';
    } else {
        $layout = 'side-pre-only';
    }
} else if (!$showsidepost && !$showsidepre) {
    $layout = 'content-only';
}
$bodyclasses[] = $layout;
if ($hascustommenu) {
    $bodyclasses[] = 'has_custom_menu';
}
?>

<?php echo $OUTPUT->doctype() ?> <!-- Doc type -->

<html <?php echo $OUTPUT->htmlattributes() ?>> <!-- HTML Attributes -->

<!-- HEAD section -->
    <head>
        <title><?php echo $PAGE->title ?></title>
        <link rel="shortcut icon" href="<?php echo $OUTPUT->pix_url('favicon', 'theme')?>" />
        <?php echo $OUTPUT->standard_head_html() ?> <!-- Applies any moodle specific or custom additional HEAD content -->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
<!-- BODY section - including additional bodyclasses-->
    <body id="<?php p($PAGE->bodyid) ?>" class="<?php p($PAGE->bodyclasses.' '.join($bodyclasses)) ?>">
    <?php echo $OUTPUT->standard_top_of_body_html() ?>
    <div id="page">
        <?php if ($hasheading || $hasnavbar || !empty($courseheader)) { ?>
            <div id="page-header">
                <?php if ($hasheading) { ?>
                <header role="banner"> <!--HTML5 header section used as main page header-->
                    <div class="brand">
                    <!-- main page title - use css to add logo if required -->
                        <h1 class="headermain"><?php echo $PAGE->heading ?></h1>
                        <div class="headermenu"> <!-- div to hold login info and lang menu -->
                            <?php
                                echo $OUTPUT->login_info();
                                if (!empty($PAGE->layout_options['langmenu'])) {
                                    echo $OUTPUT->lang_menu();
                                }
                                echo $PAGE->headingmenu;
                            ?>
                        </div>
                    </div>
                </header>
                <?php
                }
                ?>
                <!-- custommenu in HTML5 nav section-->
                <?php if ($hascustommenu) {?>
                    <nav role="navigation" class="navbar navbar-inner">
                        <div class="container-fluid">
                            <a class="btn btn-navbar" data-toggle="workaround-collapse" data-target=".nav-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </a>
                            <div class="nav-collapse collapse">
                                <?php if ($hascustommenu) {
                                    echo $custommenu;
                                } ?>
                            </div>
                        </div>
                    </nav>
                <?php
                }
                ?>        
                <?php if ($hasnavbar) { ?>
                    <nav class="breadcrumb-button"><?php echo $PAGE->button; ?></nav>
                    <?php echo $OUTPUT->navbar(); ?>
                <?php
                }
                ?>
        
                <?php if (!empty($courseheader)) { ?>
                    <header>
                        <div id="course-header"><?php echo $courseheader; ?></div>
                    </header>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>
        <div id="page-content">
        <div id="colmask">
            <div id="colmid">
                <div id="colleft">
                    <div id="col1wrap"><!-- Column 1 start -->
                        <section id="col1">
                            <div id="region-main">
                                <div class="container region-content">
                                    <?php echo $coursecontentheader; ?>
                                    <?php echo $OUTPUT->main_content() ?>
                                    <?php echo $coursecontentfooter; ?>
                                </div>
                            </div>
                        </section>
                    </div><!-- Column 1 end -->
                    <?php if ($hassidepre OR (right_to_left() AND $hassidepost)) { ?>
                    <aside id="col2"><!-- Column 2 start -->
                        <div id="region-pre" class="block-region region-content">
                        <div class="container region-content">
                            <?php if (!right_to_left()) {
                                echo $OUTPUT->blocks_for_region('side-pre');
                            } else if ($hassidepost) {
                                echo $OUTPUT->blocks_for_region('side-post');
                            }
                            ?>
                        </div>
                        </div>
                    </aside><!-- Column 2 end -->
                    <?php
                    }
                    ?>
                    <?php if ($hassidepost OR (right_to_left() AND $hassidepre)) { ?>
                    <aside id="col3"><!-- Column 3 start -->
                        <div id="region-post" class="block-region region-content">
                        <div class="container region-content">
                            <?php if (!right_to_left()) {
                                echo $OUTPUT->blocks_for_region('side-post');
                            } else if ($hassidepre) {
                                echo $OUTPUT->blocks_for_region('side-pre');
                            }
                            ?>
                        </div>
                        </div>
                    </aside><!-- Column 3 end -->
                    <?php
                    }
                    ?>
                </div><!-- colleft end -->
            </div><!-- colmid end -->
        </div><!-- colmask end -->
        </div><!-- end of page-content -->
        
        <?php if (!empty($coursefooter)) { ?>
            <div id="course-footer"><?php echo $coursefooter; ?></div>
        <?php
        }
        ?>

        <?php if ($hasfooter) { ?>
        <footer id="page-footer"> <!-- HTML5 footer section -->
            <p class="helplink"><?php echo page_doc_link(get_string('moodledocslink')); ?></p>

            <?php if ($hasfootnote) { ?>
               <div class="footnote text-center">
                   <?php echo $PAGE->theme->settings->footnote; ?>
               </div>
            <?php
            }
            ?>

            <?php
                echo $OUTPUT->login_info();
                echo $OUTPUT->home_link();
                echo $OUTPUT->standard_footer_html();
            ?> <!-- Moodle standard/additional custom footer html -->
        </footer>
        <?php
        }
        ?>
    </div><!-- end of page div-->
    <?php echo $OUTPUT->standard_end_of_body_html() ?> <!-- Moodle standard/additional custom end of body html -->
    </body>
</html>
