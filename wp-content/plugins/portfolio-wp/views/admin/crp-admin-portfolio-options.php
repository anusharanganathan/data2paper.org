<?php

$crp_pid = isset($_GET['id']) ? $_GET['id'] : 0;

function crp_tooltipForOption($option){
    $tooltip = "";
    $tooltip .= "<div class=\"crp-tooltip-content\">";
    $tooltip .=      "<img src=\"". CRP_IMAGES_URL ."/general/glazzed-image-placeholder.png\" />";
    $tooltip .= "</div>";

    $tooltip = htmlentities($tooltip);
    return $tooltip;
}

function crp_layoutWithName($name, $active = ''){
    $layoutType = layoutTypeWithName($name);
    $html = "";

    $html .= "<li id='{$layoutType}' class='crp-layout-type-option {$active}' "; if ($name == 'square') { $html .= "onClick='onChooseLayout(event,this)'"; } $html .= ">";
    $html .=    "<a>";
    $html .=        "<div class='crp-layout-thumb crp-layout-{$name}'>";
    $html .=            "<div class='crp-thumb-overlay'>";
//    $html .=                "<img class='crp-layout-tick'>";
    if ($name == 'square') {
        $html .= "<i class='crp-layout-tick fa fa-check'></i>";
    } else {
        $html .= "<span class='crp-layout-type-pro'>PRO</span>";
    }
    $html .=            "</div>";
    $html .=        "</div>";
    $html .=    "</a>";
    $html .= "</li>";

    return $html;
}

function layoutTypeWithName($name){

    if($name == "masonry"){
        return CRPViewType::Masonry;
    }else if($name == "puzzle"){
        return CRPViewType::Puzzle;
    }else if($name == "square"){
        return CRPViewType::Square;
    }else if($name == "list"){
        return CRPViewType::WaterfallList;
    }else if($name == "slider"){
        return CRPViewType::Slider;
    }else{
        return CRPViewType::Unknown;
    }
}

function crp_inflateFontawosomeIconOptions(){
    $html ='<option value="">None</option>
            <option value="diamond" disabled="disabled">Diamond (PRO)</option>
            <option value="leanpub" disabled="disabled">Leanpub (PRO)</option>
            <option value="neuter" disabled="disabled">Neuter (PRO)</option>
            <option value="bolt" disabled="disabled">Bolt (PRO)</option>
            <option value="bookmark" disabled="disabled">Bookmark (PRO)</option>
            <option value="bookmark-o" disabled="disabled">Bookmark Outline (PRO)</option>
            <option value="bug" disabled="disabled">Bug (PRO)</option>
            <option value="bullseye" disabled="disabled">Bullseye (PRO)</option>
            <option value="camera" disabled="disabled">Camera (PRO)</option>
            <option value="camera-retro" disabled="disabled">Camera Retro (PRO)</option>
            <option value="check" disabled="disabled">Check (PRO)</option>
            <option value="check-circle" disabled="disabled">Check Circle (PRO)</option>
            <option value="check-circle-o" disabled="disabled">Check Circle Outline (PRO)</option>
            <option value="cloud" disabled="disabled">Cloud (PRO)</option>
            <option value="coffee" disabled="disabled">Coffee (PRO)</option>
            <option value="comment" disabled="disabled">Comment (PRO)</option>
            <option value="comment-o" disabled="disabled">Comment Outline (PRO)</option>
            <option value="crosshairs" disabled="disabled">Crosshairs (PRO)</option>
            <option value="dot-circle-o" disabled="disabled">Dot Circle Outline (PRO)</option>
            <option value="external-link" disabled="disabled">External Link (PRO)</option>
            <option value="eye" disabled="disabled">Eye (PRO)</option>
            <option value="file-image-o" disabled="disabled">File Image (PRO)</option>
            <option value="fire" disabled="disabled">Fire (PRO)</option>
            <option value="folder-open" disabled="disabled">Folder Open (PRO)</option>
            <option value="folder-open-o" disabled="disabled">Folder Open Outline (PRO)</option>
            <option value="heart" disabled="disabled">Heart (PRO)</option>
            <option value="heart-o" disabled="disabled">Heart Outline (PRO)</option>
            <option value="heartbeat" disabled="disabled">Heartbeat (PRO)</option>
            <option value="info" disabled="disabled">Info (PRO)</option>
            <option value="info-circle" disabled="disabled">Info Circle (PRO)</option>
            <option value="lightbulb-o" disabled="disabled">LIghtbulb (PRO)</option>
            <option value="magic" disabled="disabled">Magic (PRO)</option>
            <option value="paper-plane" disabled="disabled">Paper Plane (PRO)</option>
            <option value="paper-plane-o" disabled="disabled">Paper Plane Outline (PRO)</option>
            <option value="paw" disabled="disabled">Paw (PRO)</option>
            <option value="photo" disabled="disabled">Photo (PRO)</option>
            <option value="plug" disabled="disabled">Plug (PRO)</option>
            <option value="search" disabled="disabled">Search (PRO)</option>
            <option value="search-plus" disabled="disabled">Search Plus (PRO)</option>
            <option value="star" disabled="disabled">Star (PRO)</option>
            <option value="star" disabled="disabled">Star Outline (PRO)</option>
            <option value="tag" disabled="disabled">Label (PRO)</option>
            <option value="thumbs-up" disabled="disabled">Thumbs Up (PRO)</option>
            <option value="chain" disabled="disabled">Chain (PRO)</option>
            <option value="chain-broken" disabled="disabled">Chain Broken (PRO)</option>
            <option value="link" disabled="disabled">Link (PRO)</option>
            <option value="hand-o-right" disabled="disabled">Hand Right (PRO)</option>
            <option value="hand-o-up" disabled="disabled">Hand Up (PRO)</option>
            <option value="arrows" disabled="disabled">Arrows (PRO)</option>
            <option value="expand" disabled="disabled">Expand (PRO)</option>';
    return $html;
}

function crp_inflateOpacityOptions(){
    $html = '<option value="FF">100%</option>
             <option value="F2">95%</option>
             <option value="E6">90%</option>
             <option value="D9">85%</option>
             <option value="CC">80%</option>
             <option value="BF">75%</option>
             <option value="B3">70%</option>
             <option value="A6">65%</option>
             <option value="99">60%</option>
             <option value="8C">55%</option>
             <option value="80">50%</option>
             <option value="73">45%</option>
             <option value="66">40%</option>
             <option value="59">35%</option>
             <option value="4D">30%</option>
             <option value="40">25%</option>
             <option value="33">20%</option>
             <option value="26">15%</option>
             <option value="1A">10%</option>
             <option value="0D">5%</option>
             <option value="00">0%</option>';

    return $html;
}

?>

<div class="crp-options-header">
    <div class="crp-three-parts crp-fl">
        <a class='button-secondary portfolio-button crp-glazzed-btn crp-glazzed-btn-dark' href="<?php echo "?page={$crp_adminPage}"; ?>">
            <div class='crp-icon crp-portfolio-button-icon'><i class="fa fa-long-arrow-left"></i></div>
        </a>
    </div>

    <div class="crp-three-parts crp-fl crp-title-part crp-settings-title"><span>Settings</span></div>

    <div class="crp-three-parts crp-fr">
        <a id="crp-save-options-button" class='button-secondary options-button crp-glazzed-btn crp-glazzed-btn-green' href="#">
            <div class='crp-icon crp-portfolio-button-icon'><i class="fa fa-save fa-fw"></i></div>
        </a>
    </div>
</div>

<hr />

<div id="crp-options-accordion" class="crp-options-wrapper">

    <div class="collapse-card active">
        <div class="title">
            Layout type
        </div>
        <div class="body" style="display: block">
            <div class="crp-options-section">
                <ul class="crp-layouts">
                    <?php echo crp_layoutWithName('square'); ?>
                    <?php echo crp_layoutWithName('masonry'); ?>
                    <?php echo crp_layoutWithName('puzzle'); ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Display elements
        </div>
        <div class="body">
            <div class="crp-options-section crp-social-networks">
                <div class="crp-fl" style="margin-right: 150px;">
                    <div class="crp-options-row">
                        <label>Show title:</label>
                        <input id="<?php echo CRPOption::kShowTitle ?>" type="checkbox">
                        <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="crp-options-row">
                        <label>Show description:</label>
                        <input id="<?php echo CRPOption::kShowDesc ?>" type="checkbox">
                        <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    </div>

                    <div class="crp-options-row">
                        <label>Show overlay:</label>
                        <input id="<?php echo CRPOption::kShowOverlay ?>" type="checkbox" disabled="disabled">
                        <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                        <?php echo CRPHelper::proMark(); ?>
                    </div>

                    <div class="crp-options-row">
                        <label>Show link button:</label>
                        <input id="<?php echo CRPOption::kShowLinkButton ?>" type="checkbox" disabled="disabled">
                        <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                        <?php echo CRPHelper::proMark(); ?>
                    </div>

                    <div class="crp-options-row">
                        <label>Show explore button:</label>
                        <input id="<?php echo CRPOption::kShowExploreButton ?>" type="checkbox" disabled="disabled">
                        <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                        <?php echo CRPHelper::proMark(); ?>
                    </div>
                </div>
                <div class="crp-fl">
                    <div class="crp-options-row">
                        <label>Show Facebook button:</label>
                        <input id="<?php echo CRPOption::kShowFacebookButton ?>" type="checkbox" disabled="disabled">
                        <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                        <?php echo CRPHelper::proMark(); ?>
                    </div>

                    <div class="crp-options-row">
                        <label>Show Twitter button:</label>
                        <input id="<?php echo CRPOption::kShowTwitterButton ?>" type="checkbox" disabled="disabled">
                        <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                        <?php echo CRPHelper::proMark(); ?>
                    </div>

                    <div class="crp-options-row">
                        <label>Show Google+ button:</label>
                        <input id="<?php echo CRPOption::kShowGooglePlusButton ?>" type="checkbox" disabled="disabled">
                        <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                        <?php echo CRPHelper::proMark(); ?>
                    </div>

                    <div class="crp-options-row">
                        <label>Show Pinterest button:</label>
                        <input id="<?php echo CRPOption::kShowPinterestButton ?>" type="checkbox" disabled="disabled">
                        <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                        <?php echo CRPHelper::proMark(); ?>
                    </div>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Styles & effects
        </div>
        <div class="body">
            <div class="crp-options-section">

                <br/>
                <div class="crp-options-row">
                    <label>Popup style:</label>

                    <select id="<?php echo CRPOption::kViewerType ?>">
                        <option value="<?php echo CRPPjViewerType::LightGallery ?>" selected="true">Dark</option>
                        <option value="" disabled="disabled">Dark (Full) (PRO)</option>
                        <option value="<?php echo CRPPjViewerType::LightGalleryLight ?>" disabled="disabled">Light (PRO)</option>
                    </select>

                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <br/><hr/><br/>
                <div class="crp-options-row">
                    <label>Category filter style:</label>

                    <select id="<?php echo CRPOption::kFilterStyle ?>">
                        <option value="" selected="selected">None</option>
                        <option value="<?php echo CRPFilterStyle::style1 ?>" disabled="disabled">Style 1 (PRO)</option>
                        <option value="<?php echo CRPFilterStyle::style2 ?>" disabled="disabled">Style 2 (PRO)</option>
                        <option value="<?php echo CRPFilterStyle::style3 ?>" disabled="disabled">Style 3 (PRO)</option>
                        <option value="<?php echo CRPFilterStyle::style4 ?>" disabled="disabled">Style 4 (PRO)</option>
                        <option value="<?php echo CRPFilterStyle::style5 ?>" disabled="disabled">Style 5 (PRO)</option>
                        <option value="<?php echo CRPFilterStyle::style6 ?>" disabled="disabled">Style 6 (PRO)</option>
                        <option value="<?php echo CRPFilterStyle::style7 ?>" disabled="disabled">Style 7 (PRO)</option>
                    </select>

                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Pagination style:</label>

                    <select id="<?php echo CRPOption::kPaginationStyle ?>">
                        <option value="" selected="selected">None</option>
                        <option value="<?php echo CRPPaginationStyle::style1 ?>" disabled="disabled">Style 1 (PRO)</option>
                        <option value="<?php echo CRPPaginationStyle::style2 ?>" disabled="disabled">Style 2 (PRO)</option>
                        <option value="<?php echo CRPPaginationStyle::style3 ?>" disabled="disabled">Style 3 (PRO)</option>
                        <option value="<?php echo CRPPaginationStyle::style4 ?>" disabled="disabled">Style 4 (PRO)</option>
                        <option value="<?php echo CRPPaginationStyle::style5 ?>" disabled="disabled">Style 5 (PRO)</option>
                        <option value="<?php echo CRPPaginationStyle::style6 ?>" disabled="disabled">Style 6 (PRO)</option>
                        <option value="<?php echo CRPPaginationStyle::style7 ?>" disabled="disabled">Style 7 (PRO)</option>
                    </select>

                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <br/><hr/><br/>
                <div class="crp-options-row">
                    <label>Picture hover effect:</label>

                    <select id="<?php echo CRPOption::kPictureHoverEffect ?>">
                        <option value="<?php echo CRPPictureHoverStyle::none ?>" selected="true">None</option>
                        <option value="<?php echo CRPPictureHoverStyle::style01 ?>" disabled="disabled"> Zoom in (PRO)</option>
                        <option value="<?php echo CRPPictureHoverStyle::style02 ?>" disabled="disabled"> Zoom out (PRO)</option>
                        <option value="<?php echo CRPPictureHoverStyle::style03 ?>" disabled="disabled"> Blur (PRO)</option>
                        <option value="<?php echo CRPPictureHoverStyle::style04 ?>" disabled="disabled"> Zoom in & blur (PRO)</option>
                        <option value="<?php echo CRPPictureHoverStyle::style05 ?>" disabled="disabled"> RGB to grayscale (PRO)</option>
                        <option value="<?php echo CRPPictureHoverStyle::style06 ?>" disabled="disabled"> Grayscale to RGB (PRO)</option>
                        <option value="<?php echo CRPPictureHoverStyle::style07 ?>" disabled="disabled"> Zoom in & rotate (PRO)</option>
                    </select>

                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Overlay display style:</label>

                    <select id="<?php echo CRPOption::kOverlayDisplayStyle ?>">
                        <option value="" selected="true">None</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style00 ?>" disabled="disabled"> Fade in (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style01 ?>" disabled="disabled"> Overlap top & bottom (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style02 ?>" disabled="disabled"> Overlap left & right (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style03 ?>" disabled="disabled"> Overlap from corners - 1 (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style04 ?>" disabled="disabled"> Overlap from corners - 2 (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style05 ?>" disabled="disabled"> Overlap partially (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style06 ?>" disabled="disabled"> Opposite gravity from corners (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style07 ?>" disabled="disabled"> Merge top & bottom (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style08 ?>" disabled="disabled"> Merge left & right (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style12 ?>" disabled="disabled"> Left-bottom to right-top (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style13 ?>" disabled="disabled"> Bounce bottom (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style14 ?>" disabled="disabled"> Zoom out & bounce (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style15 ?>" disabled="disabled"> Bounce left & right (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style16 ?>" disabled="disabled"> Bounce top & bottom (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style17 ?>" disabled="disabled"> Gradient top to bottom (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style18 ?>" disabled="disabled"> Gradient right to left (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style19 ?>" disabled="disabled"> Gradient bottom to top (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style20 ?>" disabled="disabled"> Gradient left to right (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style21 ?>" disabled="disabled"> Flip from top (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style22 ?>" disabled="disabled"> Flip from right (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style23 ?>" disabled="disabled"> Flip from bottom (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style24 ?>" disabled="disabled"> Flip from left (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style25 ?>" disabled="disabled"> Rotation (PRO)</option>
                        <option value="<?php echo CRPOverlayDisplayStyle::style27 ?>" disabled="disabled"> Top to bottom (PRO)</option>
                    </select>

                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Title & description display style:</label>

                    <select id="<?php echo CRPOption::kDetailsDisplayStyle ?>">
                        <optgroup label=" - Without background - ">
                            <option value="<?php echo CRPDetailsDisplayStyle::style01 ?>" disabled="disabled"> Left to right (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style02 ?>" disabled="disabled"> Top to bottom (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style03 ?>" disabled="disabled"> Right to left (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style04 ?>" disabled="disabled"> Bottom to top (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style11 ?>" disabled="disabled"> Zoom in & rotate (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style23 ?>" disabled="disabled"> Gravity to bottom (PRO) </option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style24 ?>" disabled="disabled"> Gravity to top (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style25 ?>" disabled="disabled"> Appear from left & bottom (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style26 ?>" disabled="disabled"> Gravity to center (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style27 ?>" disabled="disabled"> Zoom in 1 (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style28 ?>" disabled="disabled"> Zoom in 2 (PRO)</option>
                        </optgroup>
                        <optgroup label=" - With background - ">
                            <option value="<?php echo CRPDetailsDisplayStyle::style31 ?>" disabled="disabled"> Static on top (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style32 ?>" disabled="disabled"> Static on bottom (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style33 ?>" selected="true"> Appear from bottom</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style34 ?>" disabled="disabled"> Appear from top (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style35 ?>" disabled="disabled"> Left to right on top (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style36 ?>" disabled="disabled"> Right to left on top (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style37 ?>" disabled="disabled"> Left to right on bottom (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style38 ?>" disabled="disabled"> Right to left on bottom (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style39 ?>" disabled="disabled"> Flip from top (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style40 ?>" disabled="disabled"> Flip from bottom (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style41 ?>" disabled="disabled"> Appear from top & stick on bottom (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style42 ?>" disabled="disabled"> Appear from bottom & stick on top (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style43 ?>" disabled="disabled"> Zoom in & stick on bottom (PRO)</option>
                            <option value="<?php echo CRPDetailsDisplayStyle::style44 ?>" disabled="disabled"> Zoom in & stick on top (PRO)</option>
                        </optgroup>
                    </select>

                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Overlay buttons display style:</label>

                    <select id="<?php echo CRPOption::kOverlayButtonsDisplayStyle ?>">
                        <option value="" selected="selected">None</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style01 ?>" disabled="disabled"> Top to center (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style02 ?>" disabled="disabled"> Left to center (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style03 ?>" disabled="disabled"> Bottom to center (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style04 ?>" disabled="disabled"> Right to center (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style05 ?>" disabled="disabled"> Fade in (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style06 ?>" disabled="disabled"> Horizontal gravity to center (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style07 ?>" disabled="disabled"> Fade in & zoom in (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style08 ?>" disabled="disabled"> Fade in & zoom out (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style11 ?>" disabled="disabled"> Rotate & zoom in (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style13 ?>" disabled="disabled"> Opposite rotation (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style15 ?>" disabled="disabled"> Roll & fade in (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style16 ?>" disabled="disabled"> Vertical gravity & rotation (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style21 ?>" disabled="disabled"> Horizontal scale (PRO)</option>
                        <option value="<?php echo CRPOverlayButtonsDisplayStyle::style22 ?>" disabled="disabled"> Vertical scale (PRO)</option>
                    </select>

                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Overlay buttons hover effect:</label>

                    <select id="<?php echo CRPOption::kOverlayButtonsHoverEffect ?>">
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::none ?>" selected="true" > None</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style30 ?>" disabled="disabled"> Sweep to right</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style31 ?>" disabled="disabled"> Sweep to left</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style32 ?>" disabled="disabled"> Sweep to bottom</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style33 ?>" disabled="disabled"> Sweep to top</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style34 ?>" disabled="disabled"> Bounce to right</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style35 ?>" disabled="disabled"> Bounce to left</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style36 ?>" disabled="disabled"> Bounce to bottom</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style37 ?>" disabled="disabled"> Bounce to top</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style38 ?>" disabled="disabled"> Radial out</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style39 ?>" disabled="disabled"> Radial in</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style40 ?>" disabled="disabled"> Rectangle in</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style41 ?>" disabled="disabled"> Rectangle out</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style42 ?>" disabled="disabled"> Shutter in horizontal</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style43 ?>" disabled="disabled"> Shutter out horizontal</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style44 ?>" disabled="disabled"> Shutter in vertical</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style45 ?>" disabled="disabled"> Shutter out vertical</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style46 ?>" disabled="disabled"> Underline from left</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style47 ?>" disabled="disabled"> Underline from center</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style48 ?>" disabled="disabled"> Underline from right</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style49 ?>" disabled="disabled"> Underline reveal</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style50 ?>" disabled="disabled"> Overline reveal</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style51 ?>" disabled="disabled"> Overline from left</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style52 ?>" disabled="disabled"> Overline from center</option>
                        <option value="<?php echo CRPOverlayButtonsHoverEffect::style53 ?>" disabled="disabled"> Overline from right</option>
                    </select>

                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Share buttons display style:</label>

                    <select id="<?php echo CRPOption::kShareButtonsDisplayStyle ?>">
                        <option value="" selected="selected">None</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style01 ?>" disabled="disabled"> Horizontal static on top-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style02 ?>" disabled="disabled"> Horizontal static on bottom-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style03 ?>" disabled="disabled"> Horizontal static on top-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style04 ?>" disabled="disabled"> Horizontal Static on bottom-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style05 ?>" disabled="disabled"> Horizontal appear on top-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style06 ?>" disabled="disabled"> Horizontal appear on bottom-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style07 ?>" disabled="disabled"> Horizontal appear on top-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style08 ?>" disabled="disabled"> Horizontal appear on bottom-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style09 ?>" disabled="disabled"> Vertical static on top-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style10 ?>" disabled="disabled"> Vertical static on bottom-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style11 ?>" disabled="disabled"> Vertical static on top-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style12 ?>" disabled="disabled"> Vertical static on bottom-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style13 ?>" disabled="disabled"> Vertical appear on top-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style14 ?>" disabled="disabled"> Vertical appear on bottom-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style15 ?>" disabled="disabled"> Vertical appear on top-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style16 ?>" disabled="disabled"> Vertical appear on bottom-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style17 ?>" disabled="disabled"> Horizontal gravity on top-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style18 ?>" disabled="disabled"> Horizontal gravity on bottom-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style19 ?>" disabled="disabled"> Horizontal gravity on top-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style20 ?>" disabled="disabled"> Horizontal gravity on bottom-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style21 ?>" disabled="disabled"> Vertical gravity on top-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style22 ?>" disabled="disabled"> Vertical gravity on bottom-left (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style23 ?>" disabled="disabled"> Vertical gravity on top-right (PRO)</option>
                        <option value="<?php echo CRPShareButtonsDisplayStyle::style24 ?>" disabled="disabled"> Vertical gravity on bottom-right (PRO)</option>
                    </select>

                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Mouse style:</label>
                    <select id="<?php echo CRPOption::kMouseType ?>">
                        <option value="default">Default</option>
                        <option value="pointer" selected="true">Hand</option>
                        <option value="crosshair">Crosshair</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>


            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Colorizations
        </div>
        <div class="body">
            <div class="crp-options-section">

                <br/>
                <div class="crp-options-row fh">
                    <label>Progress bar color:</label>
                    <input id="<?php echo CRPOption::kProgressColor ?>" type="text" class="cpa-color-picker cpa-pro">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <br/><hr/><br/>
                <div class="crp-options-row fh">
                    <label>Filter color:</label>
                    <input id="<?php echo CRPOption::kFiltersColor ?>" type="text" class="cpa-color-picker cpa-pro">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Active filters color:</label>
                    <input id="<?php echo CRPOption::kFiltersHoverColor ?>" type="text" class="cpa-color-picker cpa-pro">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <br/><hr/><br/>
                <div class="crp-options-row fh">
                    <label>Pagination color:</label>
                    <input id="<?php echo CRPOption::kPaginationColor ?>" type="text" class="cpa-color-picker cpa-pro">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Active page color:</label>
                    <input id="<?php echo CRPOption::kPaginationHoverColor ?>" type="text" class="cpa-color-picker cpa-pro">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <br/><hr/><br/>
                <div class="crp-options-row fh">
                    <label>Title color:</label>
                    <input id="<?php echo CRPOption::kTileTitleColor ?>" type="text" class="cpa-color-picker">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row fh">
                    <label>Description color:</label>
                    <input id="<?php echo CRPOption::kTileDescColor ?>" type="text" class="cpa-color-picker">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row fh">
                    <label>Overlay color:</label>
                    <input id="<?php echo CRPOption::kTileOverlayColor ?>" type="text" class="cpa-color-picker">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row fh">
                    <label>Overlay opacity:</label>
                    <select id="<?php echo CRPOption::kTileOverlayOpacity ?>" class="w2">
                        <?php echo crp_inflateOpacityOptions(); ?>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row fh">
                    <label>Overlay button color:</label>
                    <input id="<?php echo CRPOption::kTileIconsBgColor ?>" type="text" class="cpa-color-picker cpa-pro">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Overlay button icon color:</label>
                    <input id="<?php echo CRPOption::kTileIconsColor ?>" type="text" class="cpa-color-picker cpa-pro">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Dimensions
        </div>
        <div class="body">
            <div class="crp-options-section">
                <div class="crp-options-row fh">
                    <label>Grid width:</label>
                    <input id="<?php echo CRPOption::kLayoutWidth ?>" class="only-digits" type="text" disabled="disabled">
                    <select id="<?php echo CRPOption::kLayoutWidthUnit ?>" class="unit" disabled="disabled">
                        <option value="%" selected="true" disabled="disabled">%</option>
                        <option value="px">px</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Tile approximate width:</label>
                    <input id="<?php echo CRPOption::kTileApproxWidth ?>" class="only-digits" type="text"  disabled="disabled">
                    <select id="<?php echo CRPOption::kTileApproxWidth ?>-unit" class="unit" disabled="disabled">
                        <option value="%">%</option>
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Tile approximate height:</label>
                    <input id="<?php echo CRPOption::kTileApproxHeight ?>" class="only-digits" type="text" disabled="disabled">
                    <select id="<?php echo CRPOption::kTileApproxHeight ?>-unit" class="unit" disabled="disabled">
                        <option value="%">%</option>
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Tile min width:</label>
                    <input id="<?php echo CRPOption::kTileMinWidth ?>" class="only-digits" type="text" disabled="disabled">
                    <select id="<?php echo CRPOption::kTileMinWidth ?>-unit" class="unit" disabled="disabled">
                        <option value="%">%</option>
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Tile margins:</label>
                    <input id="<?php echo CRPOption::kTileMargins ?>" class="only-digits" type="text" disabled="disabled">
                    <select id="<?php echo CRPOption::kTileMargins ?>-unit" class="unit" disabled="disabled">
                        <option value="%">%</option>
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Fonts & icons
        </div>
        <div class="body">
            <div class="crp-options-section">

                <div class="crp-options-row fh">
                    <label>Tile title font size:</label>
                    <input id="<?php echo CRPOption::kTileTitleFontSize?>" class="only-digits" type="text" disabled="disabled">
                    <select class="unit" disabled="disabled">
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Tile description font size:</label>
                    <input id="<?php echo CRPOption::kTileDescFontSize?>" class="only-digits" type="text" disabled="disabled">
                    <select class="unit" disabled="disabled">
                        <option value="px" selected="true">px</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row">
                    <label>Tile title alignment:</label>
                    <select id="<?php echo CRPOption::kTileTitleAlignment ?>">
                        <option value="left" disabled="disabled">Left (PRO)</option>
                        <option value="right" disabled="disabled">Right (PRO)</option>
                        <option value="center" selected="true">Center</option>
                        <option value="justify" disabled="disabled">Justify (PRO)</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Tile description alignment:</label>
                    <select id="<?php echo CRPOption::kTileDescAlignment ?>">
                        <option value="left" disabled="disabled">Left (PRO)</option>
                        <option value="right" disabled="disabled">Right (PRO)</option>
                        <option value="center" selected="true">Center</option>
                        <option value="justify" disabled="disabled">Justify (PRO)</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <br/><hr/><br/>
                <div class="crp-options-row">
                    <label>Link icon:</label>
                    <select id="<?php echo CRPOption::kLinkIcon ?>">
                        <?php echo crp_inflateFontawosomeIconOptions(); ?>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Zoom icon:</label>
                    <select id="<?php echo CRPOption::kZoomIcon ?>">
                        <?php echo crp_inflateFontawosomeIconOptions(); ?>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Advanced
        </div>
        <div class="body">
            <div class="crp-options-section crp-social-networks">

                <div class="crp-options-row">
                    <label>Enable lazy loading:</label>
                    <input id="<?php echo CRPOption::kEnableGridLazyLoad ?>" type="checkbox" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row">
                    <label>Don't show popup:</label>
                    <input id="<?php echo CRPOption::kDirectLinking ?>" type="checkbox">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row">
                    <label>Load url in a new tab:</label>
                    <input id="<?php echo CRPOption::kLoadUrlBlank ?>" type="checkbox" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row">
                    <label>Disable album style presentation:</label>
                    <input id="<?php echo CRPOption::kDisableAlbumStylePresentation ?>" type="checkbox" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row">
                    <label>Enable picture caption for popup:</label>
                    <input id="<?php echo CRPOption::kEnablePictureCaptions ?>" type="checkbox" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row">
                    <label>Exclude cover picture for popup:</label>
                    <input id="<?php echo CRPOption::kExcludeCoverPicture ?>" type="checkbox" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Tile description max length (words):</label>
                    <input id="<?php echo CRPOption::kDescMaxLength ?>" class="only-digits" type="text" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>


                <br/><hr/><br/>

                <div class="crp-options-row">
                    <label>Show category filters:</label>
                    <input id="<?php echo CRPOption::kShowCategoryFilters ?>" type="checkbox" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row">
                    <label>Hide `All` category filter:</label>
                    <input id="<?php echo CRPOption::kHideAllCategoryFilter ?>" type="checkbox" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>


                <div class="crp-options-row fh">
                    <label>Category filter `All` alias:</label>
                    <input id="<?php echo CRPOption::kAllCategoryAlias; ?>" type="text" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>


                <br/><hr/><br/>

                <div class="crp-options-row">
                    <label>Enable pagination:</label>
                    <input id="<?php echo CRPOption::kEnablePagination; ?>" type="checkbox" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Items count per page:</label>
                    <input id="<?php echo CRPOption::kItemsPerPage; ?>" class="only-digits" type="text" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Max visible page numbers:</label>
                    <input id="<?php echo CRPOption::kMaxVisiblePageNumbers; ?>" class="only-digits" type="text" disabled="disabled">
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                    <?php echo CRPHelper::proMark(); ?>
                </div>

                <div class="crp-options-row fh">
                    <label>Pagination alignment:</label>
                    <select id="<?php echo CRPOption::kPaginationAlignment; ?>">
                        <option value="" selected="selected">None</option>
                        <option value="center" disabled="disabled">Center (PRO)</option>
                        <option value="left" disabled="disabled">Left (PRO)</option>
                        <option value="right" disabled="disabled">Right (PRO)</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <br/><hr/><br/>

                <div class="crp-options-row">
                    <label>Grid thumbnail quality:</label>

                    <select id="<?php echo CRPOption::kThumbnailQuality ?>">
                        <option value="medium" disabled="disabled">Medium (PRO)</option>
                        <option value="large" selected="true">Large</option>
                        <option value="original" disabled="disabled">Original (PRO)</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

                <div class="crp-options-row fh">
                    <label>Grid alignment:</label>
                    <select id="<?php echo CRPOption::kLayoutAlignment ?>">
                        <option value="" selected="selected">None</option>
                        <option value="center" disabled="disabled">Center (PRO)</option>
                        <option value="left" disabled="disabled">Left (PRO)</option>
                        <option value="right" disabled="disabled">Right (PRO)</option>
                    </select>
                    <i class="fa fa-info-circle tooltip" title="<?php echo crp_tooltipForOption('opname'); ?>"></i>
                </div>

            </div>
        </div>
    </div>

    <div class="collapse-card">
        <div class="title">
            Custom CSS & JS
        </div>
        <div class="body">
            <div class="crp-options-section">
                <textarea id="<?php echo CRPOption::kCustomCSS ?>" placeholder="Enter CSS without using <style></style> tags"></textarea>
                <textarea id="<?php echo CRPOption::kCustomJS ?>" placeholder="Enter JS without using <script></script> tags"></textarea>
            </div>
        </div>
    </div>

</div>

<!--Here Goes JS-->
<script>
    //Show loading while the page is being complete loaded
    crp_showSpinner();

    //Configure javascript vars passed PHP
    var crp_adminPage = "<?php echo $crp_adminPage ?>";
    var crp_pid = "<?php echo $crp_pid ?>";

    crp_options = {};

    jQuery(document).ready(function() {
        //Setup colorpicker
        jQuery(function() {
            jQuery( '.cpa-color-picker' ).wpColorPicker();
            jQuery( '.cpa-color-picker.cpa-pro' ).closest('.wp-picker-container').unbind('click');

        });

        //Setup tooltipster
        jQuery('.tooltip').tooltipster({
            contentAsHTML: true,
            position: 'left',
            animation: 'fade', //fade, grow, swing, slide, fall
            theme: 'tooltipster-shadow'
        });

        var options = crpAjaxGetOptionsWithPid(crp_pid);
        options = CrpBase64.decode(options);
        crp_options = JSON.parse(options);

        //Update UI based on the retrieved model
        crp_updateUI();

        //When the page is ready, hide loading spinner
        crp_hideSpinner();
    });

    function onChooseLayout(event,target){
        event.preventDefault();

        jQuery(".crp-layouts li.active").removeClass("active");
        jQuery(target).addClass("active");
    }

    jQuery("#crp-save-options-button").on( 'click', function( evt ){
        evt.preventDefault();

        //Show spinner
        crp_showSpinner();

        //Apply last changes to the model
        crp_updateModel();

        //Perform Ajax calls
        var options = CrpBase64.encode(JSON.stringify(crp_options));
        var response = crpAjaxSaveOptionsWithPid(options, crp_pid);

        //Hide spinner
        crp_hideSpinner();
    });

    jQuery("#crp-back-button").on( 'click', function( evt ){
        evt.preventDefault();
        window.history.back();
    });

    jQuery(document).keypress(function(event) {
        //cmd+s or control+s
        if (event.which == 115 && (event.ctrlKey||event.metaKey)|| (event.which == 19)) {
            event.preventDefault();

            jQuery( "#crp-save-options-button" ).trigger( "click" );
            return false;
        }
        return true;
    });

    jQuery( "input[type='text'].only-digits" ).change(function() {
        var str = jQuery( this ).val();
        str = str.replace(/[^0-9]/g, '');
        if(!str){
            str = "0";
        }
        jQuery(this).attr("value",str);
    });


    function crp_updateUI(){
        //Laout style
        jQuery('.crp-layouts #' + crp_options.<?php echo CRPOption::kLayoutType ?>).addClass('active');
        //Viewer & tile caption style
        setOptionSelectedFor('#<?php echo CRPOption::kViewerType ?>', crp_options.<?php echo CRPOption::kViewerType ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kFilterStyle ?>', crp_options.<?php echo CRPOption::kFilterStyle ?>);

        setOptionSelectedFor('#<?php echo CRPOption::kDetailsDisplayStyle ?>', crp_options.<?php echo CRPOption::kDetailsDisplayStyle ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kPictureHoverEffect ?>', crp_options.<?php echo CRPOption::kPictureHoverEffect ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kOverlayDisplayStyle ?>', crp_options.<?php echo CRPOption::kOverlayDisplayStyle ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kOverlayButtonsDisplayStyle ?>', crp_options.<?php echo CRPOption::kOverlayButtonsDisplayStyle ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kShareButtonsDisplayStyle ?>', crp_options.<?php echo CRPOption::kShareButtonsDisplayStyle ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kOverlayButtonsHoverEffect ?>', crp_options.<?php echo CRPOption::kOverlayButtonsHoverEffect ?>);

        //Quality options
        setOptionSelectedFor('#<?php echo CRPOption::kThumbnailQuality ?>', crp_options.<?php echo CRPOption::kThumbnailQuality ?>);
        //Category Filtration
        jQuery('#<?php echo CRPOption::kShowCategoryFilters ?>').attr('checked', crp_options.<?php echo CRPOption::kShowCategoryFilters ?> );
        //Caption overlay
        jQuery('#<?php echo CRPOption::kShowTitle ?>').attr('checked', crp_options.<?php echo CRPOption::kShowTitle ?> );
        jQuery('#<?php echo CRPOption::kShowDesc ?>').attr('checked', crp_options.<?php echo CRPOption::kShowDesc ?> );
        jQuery('#<?php echo CRPOption::kShowOverlay ?>').attr('checked', crp_options.<?php echo CRPOption::kShowOverlay ?> );
        jQuery('#<?php echo CRPOption::kShowLinkButton ?>').attr('checked', crp_options.<?php echo CRPOption::kShowLinkButton ?> );
        jQuery('#<?php echo CRPOption::kShowExploreButton ?>').attr('checked', crp_options.<?php echo CRPOption::kShowExploreButton ?> );
        jQuery('#<?php echo CRPOption::kShowFacebookButton ?>').attr('checked', crp_options.<?php echo CRPOption::kShowFacebookButton ?> );
        jQuery('#<?php echo CRPOption::kShowTwitterButton ?>').attr('checked', crp_options.<?php echo CRPOption::kShowTwitterButton ?> );
        jQuery('#<?php echo CRPOption::kShowGooglePlusButton ?>').attr('checked', crp_options.<?php echo CRPOption::kShowGooglePlusButton ?> );
        jQuery('#<?php echo CRPOption::kShowPinterestButton ?>').attr('checked', crp_options.<?php echo CRPOption::kShowPinterestButton ?> );

        setOptionSelectedFor('#<?php echo CRPOption::kLinkIcon ?>', crp_options.<?php echo CRPOption::kLinkIcon ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kZoomIcon ?>', crp_options.<?php echo CRPOption::kZoomIcon ?>);
        //Dimensions
        jQuery('#<?php echo CRPOption::kLayoutWidth ?>').attr('value', crp_options.<?php echo CRPOption::kLayoutWidth ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kLayoutWidthUnit ?>', crp_options.<?php echo CRPOption::kLayoutWidthUnit ?>);
        jQuery('#<?php echo CRPOption::kTileApproxWidth ?>').attr('value', crp_options.<?php echo CRPOption::kTileApproxWidth ?>);
        jQuery('#<?php echo CRPOption::kTileApproxHeight ?>').attr('value', crp_options.<?php echo CRPOption::kTileApproxHeight ?>);
        jQuery('#<?php echo CRPOption::kTileMinWidth ?>').attr('value', crp_options.<?php echo CRPOption::kTileMinWidth ?>);
        jQuery('#<?php echo CRPOption::kTileMargins ?>').attr('value', crp_options.<?php echo CRPOption::kTileMargins ?>);
        //Fonts
        jQuery('#<?php echo CRPOption::kTileTitleFontSize ?>').attr('value', crp_options.<?php echo CRPOption::kTileTitleFontSize ?>);
        jQuery('#<?php echo CRPOption::kTileDescFontSize ?>').attr('value', crp_options.<?php echo CRPOption::kTileDescFontSize ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kTileTitleAlignment ?>', crp_options.<?php echo CRPOption::kTileTitleAlignment ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kTileDescAlignment ?>', crp_options.<?php echo CRPOption::kTileDescAlignment ?>);

        //Positioning
        setOptionSelectedFor('#<?php echo CRPOption::kLayoutAlignment ?>', crp_options.<?php echo CRPOption::kLayoutAlignment ?>);
        //Colorization
        jQuery('#<?php echo CRPOption::kProgressColor ?>').attr('value', crp_options.<?php echo CRPOption::kProgressColor ?>);
        jQuery('#<?php echo CRPOption::kFiltersColor ?>').attr('value', crp_options.<?php echo CRPOption::kFiltersColor ?>);
        jQuery('#<?php echo CRPOption::kFiltersHoverColor ?>').attr('value', crp_options.<?php echo CRPOption::kFiltersHoverColor ?>);
        jQuery('#<?php echo CRPOption::kTileTitleColor ?>').attr('value', crp_options.<?php echo CRPOption::kTileTitleColor ?>);
        jQuery('#<?php echo CRPOption::kTileDescColor ?>').attr('value', crp_options.<?php echo CRPOption::kTileDescColor ?>);
        jQuery('#<?php echo CRPOption::kTileOverlayColor ?>').attr('value', crp_options.<?php echo CRPOption::kTileOverlayColor ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kTileOverlayOpacity ?>', crp_options.<?php echo CRPOption::kTileOverlayOpacity ?>);
        jQuery('#<?php echo CRPOption::kTileIconsColor ?>').attr('value', crp_options.<?php echo CRPOption::kTileIconsColor ?>);
        jQuery('#<?php echo CRPOption::kTileIconsBgColor ?>').attr('value', crp_options.<?php echo CRPOption::kTileIconsBgColor ?>);
        //Other
        jQuery('#<?php echo CRPOption::kEnableGridLazyLoad ?>').attr('checked', crp_options.<?php echo CRPOption::kEnableGridLazyLoad ?> );
        jQuery('#<?php echo CRPOption::kDirectLinking ?>').attr('checked', crp_options.<?php echo CRPOption::kDirectLinking ?> );
        jQuery('#<?php echo CRPOption::kLoadUrlBlank ?>').attr('checked', crp_options.<?php echo CRPOption::kLoadUrlBlank ?> );
        jQuery('#<?php echo CRPOption::kDisableAlbumStylePresentation ?>').attr('checked', crp_options.<?php echo CRPOption::kDisableAlbumStylePresentation ?> );
        jQuery('#<?php echo CRPOption::kEnablePictureCaptions ?>').attr('checked', crp_options.<?php echo CRPOption::kEnablePictureCaptions ?> );
        jQuery('#<?php echo CRPOption::kExcludeCoverPicture ?>').attr('checked', crp_options.<?php echo CRPOption::kExcludeCoverPicture ?> );
        jQuery('#<?php echo CRPOption::kHideAllCategoryFilter ?>').attr('checked', crp_options.<?php echo CRPOption::kHideAllCategoryFilter ?> );
        jQuery('#<?php echo CRPOption::kAllCategoryAlias ?>').attr('value', crp_options.<?php echo CRPOption::kAllCategoryAlias ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kMouseType ?>', crp_options.<?php echo CRPOption::kMouseType ?>);
        jQuery('#<?php echo CRPOption::kDescMaxLength ?>').attr('value', crp_options.<?php echo CRPOption::kDescMaxLength ?>);
        jQuery('#<?php echo CRPOption::kItemsPerPage ?>').attr('value', crp_options.<?php echo CRPOption::kItemsPerPage ?>);
        jQuery('#<?php echo CRPOption::kMaxVisiblePageNumbers ?>').attr('value', crp_options.<?php echo CRPOption::kMaxVisiblePageNumbers ?>);
        jQuery('#<?php echo CRPOption::kEnablePagination ?>').attr('checked', crp_options.<?php echo CRPOption::kEnablePagination ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kPaginationAlignment ?>', crp_options.<?php echo CRPOption::kPaginationAlignment ?>);
        setOptionSelectedFor('#<?php echo CRPOption::kPaginationStyle ?>', crp_options.<?php echo CRPOption::kPaginationStyle ?>);
        jQuery('#<?php echo CRPOption::kPaginationColor ?>').attr('value', crp_options.<?php echo CRPOption::kPaginationColor ?>);
        jQuery('#<?php echo CRPOption::kPaginationHoverColor ?>').attr('value', crp_options.<?php echo CRPOption::kPaginationHoverColor ?>);

        //Custom JS & CSS
        jQuery('#<?php echo CRPOption::kCustomJS ?>').attr('value', crp_options.<?php echo CRPOption::kCustomJS ?>);
        jQuery('#<?php echo CRPOption::kCustomCSS ?>').attr('value', crp_options.<?php echo CRPOption::kCustomCSS ?>);

    }

    function crp_updateModel(){
        //Layout style
        crp_options.<?php echo CRPOption::kLayoutType ?> = jQuery('.crp-layout-type-option.active').attr('id');
        //Viewer & tile caption style
        crp_options.<?php echo CRPOption::kViewerType ?> = selectedOptionsFor('#<?php echo CRPOption::kViewerType ?>');
        crp_options.<?php echo CRPOption::kFilterStyle ?> = selectedOptionsFor('#<?php echo CRPOption::kFilterStyle ?>');

        crp_options.<?php echo CRPOption::kDetailsDisplayStyle ?> = selectedOptionsFor('#<?php echo CRPOption::kDetailsDisplayStyle ?>');
        crp_options.<?php echo CRPOption::kPictureHoverEffect ?> = selectedOptionsFor('#<?php echo CRPOption::kPictureHoverEffect ?>');
        crp_options.<?php echo CRPOption::kOverlayDisplayStyle ?> = selectedOptionsFor('#<?php echo CRPOption::kOverlayDisplayStyle ?>');
        crp_options.<?php echo CRPOption::kOverlayButtonsDisplayStyle ?> = selectedOptionsFor('#<?php echo CRPOption::kOverlayButtonsDisplayStyle ?>');
        crp_options.<?php echo CRPOption::kShareButtonsDisplayStyle ?> = selectedOptionsFor('#<?php echo CRPOption::kShareButtonsDisplayStyle ?>');
        crp_options.<?php echo CRPOption::kOverlayButtonsHoverEffect ?> = selectedOptionsFor('#<?php echo CRPOption::kOverlayButtonsHoverEffect ?>');

        //Quality Options
        crp_options.<?php echo CRPOption::kThumbnailQuality ?> = selectedOptionsFor('#<?php echo CRPOption::kThumbnailQuality ?>');
        //Category Filtration
        crp_options.<?php echo CRPOption::kShowCategoryFilters ?> = jQuery('#<?php echo CRPOption::kShowCategoryFilters ?>').is(":checked");
        //Caption overlay
        crp_options.<?php echo CRPOption::kShowTitle ?> = jQuery('#<?php echo CRPOption::kShowTitle ?>').is(":checked");
        crp_options.<?php echo CRPOption::kShowDesc ?> = jQuery('#<?php echo CRPOption::kShowDesc ?>').is(":checked");
        crp_options.<?php echo CRPOption::kShowOverlay ?> = jQuery('#<?php echo CRPOption::kShowOverlay ?>').is(":checked");
        crp_options.<?php echo CRPOption::kShowLinkButton ?> = jQuery('#<?php echo CRPOption::kShowLinkButton ?>').is(":checked");
        crp_options.<?php echo CRPOption::kShowExploreButton ?> = jQuery('#<?php echo CRPOption::kShowExploreButton ?>').is(":checked");
        crp_options.<?php echo CRPOption::kShowFacebookButton ?> = jQuery('#<?php echo CRPOption::kShowFacebookButton ?>').is(":checked");
        crp_options.<?php echo CRPOption::kShowTwitterButton ?> = jQuery('#<?php echo CRPOption::kShowTwitterButton ?>').is(":checked");
        crp_options.<?php echo CRPOption::kShowGooglePlusButton ?> = jQuery('#<?php echo CRPOption::kShowGooglePlusButton ?>').is(":checked");
        crp_options.<?php echo CRPOption::kShowPinterestButton ?> = jQuery('#<?php echo CRPOption::kShowPinterestButton ?>').is(":checked");

        crp_options.<?php echo CRPOption::kLinkIcon ?> = selectedOptionsFor('#<?php echo CRPOption::kLinkIcon ?>');
        crp_options.<?php echo CRPOption::kZoomIcon ?> = selectedOptionsFor('#<?php echo CRPOption::kZoomIcon ?>');
        //Dimensions
        crp_options.<?php echo CRPOption::kLayoutWidth ?> = jQuery('#<?php echo CRPOption::kLayoutWidth ?>').attr('value');
        crp_options.<?php echo CRPOption::kLayoutWidthUnit ?> = selectedOptionsFor('#<?php echo CRPOption::kLayoutWidthUnit ?>');
        crp_options.<?php echo CRPOption::kTileApproxWidth ?> = jQuery('#<?php echo CRPOption::kTileApproxWidth ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileApproxHeight ?> = jQuery('#<?php echo CRPOption::kTileApproxHeight ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileMinWidth ?> = jQuery('#<?php echo CRPOption::kTileMinWidth ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileMargins ?> = jQuery('#<?php echo CRPOption::kTileMargins ?>').attr('value');
        //Fonts
        crp_options.<?php echo CRPOption::kTileTitleFontSize ?> = jQuery('#<?php echo CRPOption::kTileTitleFontSize ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileDescFontSize ?> = jQuery('#<?php echo CRPOption::kTileDescFontSize ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileTitleAlignment ?> = selectedOptionsFor('#<?php echo CRPOption::kTileTitleAlignment ?>');
        crp_options.<?php echo CRPOption::kTileDescAlignment ?> = selectedOptionsFor('#<?php echo CRPOption::kTileDescAlignment ?>');

        //Positioning
        crp_options.<?php echo CRPOption::kLayoutAlignment ?> = selectedOptionsFor('#<?php echo CRPOption::kLayoutAlignment ?>');
        //Colorization
        crp_options.<?php echo CRPOption::kProgressColor ?> = jQuery('#<?php echo CRPOption::kProgressColor ?>').attr('value');
        crp_options.<?php echo CRPOption::kFiltersColor ?> = jQuery('#<?php echo CRPOption::kFiltersColor ?>').attr('value');
        crp_options.<?php echo CRPOption::kFiltersHoverColor ?> = jQuery('#<?php echo CRPOption::kFiltersHoverColor ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileTitleColor ?> = jQuery('#<?php echo CRPOption::kTileTitleColor ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileDescColor ?> = jQuery('#<?php echo CRPOption::kTileDescColor ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileOverlayColor ?> = jQuery('#<?php echo CRPOption::kTileOverlayColor ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileOverlayOpacity ?> = selectedOptionsFor('#<?php echo CRPOption::kTileOverlayOpacity ?>');
        crp_options.<?php echo CRPOption::kTileIconsColor ?> = jQuery('#<?php echo CRPOption::kTileIconsColor ?>').attr('value');
        crp_options.<?php echo CRPOption::kTileIconsBgColor ?> = jQuery('#<?php echo CRPOption::kTileIconsBgColor ?>').attr('value');

        //Other
        crp_options.<?php echo CRPOption::kEnableGridLazyLoad ?> = jQuery('#<?php echo CRPOption::kEnableGridLazyLoad ?>').is(":checked");
        crp_options.<?php echo CRPOption::kDirectLinking ?> = jQuery('#<?php echo CRPOption::kDirectLinking ?>').is(":checked");
        crp_options.<?php echo CRPOption::kLoadUrlBlank ?> = jQuery('#<?php echo CRPOption::kLoadUrlBlank ?>').is(":checked");
        crp_options.<?php echo CRPOption::kDisableAlbumStylePresentation ?> = jQuery('#<?php echo CRPOption::kDisableAlbumStylePresentation ?>').is(":checked");
        crp_options.<?php echo CRPOption::kEnablePictureCaptions ?> = jQuery('#<?php echo CRPOption::kEnablePictureCaptions ?>').is(":checked");
        crp_options.<?php echo CRPOption::kExcludeCoverPicture ?> = jQuery('#<?php echo CRPOption::kExcludeCoverPicture ?>').is(":checked");
        crp_options.<?php echo CRPOption::kHideAllCategoryFilter ?> = jQuery('#<?php echo CRPOption::kHideAllCategoryFilter ?>').is(":checked");
        crp_options.<?php echo CRPOption::kAllCategoryAlias ?> = jQuery('#<?php echo CRPOption::kAllCategoryAlias ?>').attr('value');
        crp_options.<?php echo CRPOption::kMouseType ?> = selectedOptionsFor('#<?php echo CRPOption::kMouseType ?>');
        crp_options.<?php echo CRPOption::kDescMaxLength ?> = jQuery('#<?php echo CRPOption::kDescMaxLength ?>').attr('value');
        crp_options.<?php echo CRPOption::kItemsPerPage ?> = jQuery('#<?php echo CRPOption::kItemsPerPage ?>').attr('value');
        crp_options.<?php echo CRPOption::kMaxVisiblePageNumbers ?> = jQuery('#<?php echo CRPOption::kMaxVisiblePageNumbers ?>').attr('value');
        crp_options.<?php echo CRPOption::kEnablePagination ?> = jQuery('#<?php echo CRPOption::kEnablePagination ?>').is(":checked");
        crp_options.<?php echo CRPOption::kPaginationAlignment ?> = selectedOptionsFor('#<?php echo CRPOption::kPaginationAlignment ?>');
        crp_options.<?php echo CRPOption::kPaginationStyle ?> = selectedOptionsFor('#<?php echo CRPOption::kPaginationStyle ?>');
        crp_options.<?php echo CRPOption::kPaginationColor ?> = jQuery('#<?php echo CRPOption::kPaginationColor ?>').attr('value');
        crp_options.<?php echo CRPOption::kPaginationHoverColor ?> = jQuery('#<?php echo CRPOption::kPaginationHoverColor ?>').attr('value');

        //Custom JS & CSS
        crp_options.<?php echo CRPOption::kCustomJS ?> = jQuery('#<?php echo CRPOption::kCustomJS ?>').attr('value');
        crp_options.<?php echo CRPOption::kCustomCSS ?> = jQuery('#<?php echo CRPOption::kCustomCSS ?>').attr('value');

        //alert(JSON.stringify(crp_options));
    }

    function selectedOptionsFor(selector){
        var selections = "";
        if(!selector) return selections;

        jQuery(selector + " option:selected").each(function( name, val ){
            selections += jQuery(this).val() + " ";
        });

        selections = jQuery.trim(selections);
        return selections;
    }

    function setOptionSelectedFor(selector,opVal){
        if(!selector || !opVal) return;

        //Reset all
        jQuery(selector + " option:selected").each(function( name, val ){
            jQuery(this).attr("selected", false);
        });

        //Iterate
        jQuery(selector + " option").each(function( name, val ){
            if( jQuery(this).val() === opVal){
                jQuery(this).attr("selected", true);
            }
        });
    }

</script>
