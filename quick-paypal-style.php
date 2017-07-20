<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
header('Content-Type: text/css');
$qpp_form = qpp_get_stored_setup();
$arr = explode(",",$qpp_form['alternative']);
$code='';
foreach ($arr as $item) {
    $corners=$input=$background=$paragraph=$submit='';
    $style = qpp_get_stored_style($item);
    if ($item !='') $id = '.'.$item; else $id = '.default';
    if ($style['font'] == 'plugin') {
        $font = "font-family: ".$style['text-font-family']."; font-size: ".$style['text-font-size'].";color: ".$style['text-font-colour'].";line-height:100%;";
        $inputfont = "font-family: ".$style['font-family']."; font-size: ".$style['font-size']."; color: ".$style['font-colour'].";";
        $selectfont = "font-family: ".$style['font-family']."; font-size: inherit; color: ".$style['font-colour'].";";
        $submitfont = "font-family: ".$style['font-family'];
        if ($style['header-size'] || $style['header-colour']) $header = ".qpp-style".$id." ".$style['header-type']." {font-size: ".$style['header-size']."; color: ".$style['header-colour'].";}";
    }
    $input = ".qpp-style".$id." input[type=text], .qpp-style".$id." textarea {border: ".$style['input-border'].";".$inputfont.";height:auto;line-height:normal; ".$style['line_margin'].";}";
    $input .= ".qpp-style".$id." select {border: ".$style['input-border'].";".$selectfont.";height:auto;line-height:normal;}";
     $input .= ".qpp-style".$id." .qppcontainer input + label, .qpp-style".$id." .qppcontainer textarea + label {".$inputfont."}";
    $required = ".qpp-style".$id." input[type=text].required, .qpp-style".$id." textarea.required {border: ".$style['required-border'].";}";
    $paragraph = ".qpp-style".$id." p {margin:4px 0 4px 0;padding:0;".$font.";}";
    if ($style['submitwidth'] == 'submitpercent') $submitwidth = 'width:100%;';
    if ($style['submitwidth'] == 'submitrandom') $submitwidth = 'width:auto;';
    if ($style['submitwidth'] == 'submitpixel') $submitwidth = 'width:'.$style['submitwidthset'].';';
        
    if ($style['submitposition'] == 'submitleft') $submitposition = 'text-align:left;'; else $submitposition = 'text-align:right;';
    if ($style['submitposition'] == 'submitmiddle') $submitposition = 'margin:0 auto;text-align:center;';
        
    $submitbutton = ".qpp-style".$id." p.submit {".$submitposition."}
.qpp-style".$id." #submitimage {".$submitwidth."height:auto;overflow:hidden;}
.qpp-style".$id." #submit, .qpp-style".$id." #submitimage {".$submitwidth."color:".$style['submit-colour'].";background:".$style['submit-background'].";border:".$style['submit-border'].";".$submitfont.";font-size: inherit;text-align:center;}";
    $submithover = ".qpp-style".$id." #submit:hover {background:".$style['submit-hover-background'].";}";
        
    $couponbutton = ".qpp-style".$id." #couponsubmit, .qpp-style".$id." #couponsubmit:hover{".$submitwidth."color:".$style['coupon-colour'].";background:".$style['coupon-background'].";border:".$style['submit-border'].";".$submitfont.";font-size: inherit;margin: 3px 0px 7px;padding: 6px;text-align:center;}";
    if ($style['border']<>'none') $border =".qpp-style".$id." #".$style['border']." {border:".$style['form-border'].";}";
    if ($style['background'] == 'white') {$bg = "background:#FFF";$background = ".qpp-style".$id." div {background:#FFF;}";}
    if ($style['background'] == 'color') {$background = ".qpp-style".$id." div {background:".$style['backgroundhex'].";}";$bg = "background:".$style['backgroundhex'].";";}
    if ($style['backgroundimage']) $background = ".qpp-style".$id." #".$style['border']." {background: url('".$style['backgroundimage']."');}";
    $formwidth = preg_split('#(?<=\d)(?=[a-z%])#i', $style['width']);
    if (!isset($formwidth[1])) $formwidth[1] = 'px';
    if ($style['widthtype'] == 'pixel') $width = $formwidth[0].$formwidth[1];
    else $width = '100%';
    if ($style['corners'] == 'round') $corner = '5px'; else $corner = '0';
    $corners = ".qpp-style".$id." input[type=text], .qpp-style".$id." textarea, .qpp-style".$id." select, .qpp-style".$id." #submit {border-radius:".$corner.";}";
    if ($style['corners'] == 'theme') $corners = '';
        
    $handle = $style['slider-thickness'] + 1;
    $slider = '.qpp-style'.$id.' div.rangeslider, .qpp-style'.$id.' div.rangeslider__fill {height: '.$style['slider-thickness'].'em;background: '.$style['slider-background'].';}
.qpp-style'.$id.' div.rangeslider__fill {background: '.$style['slider-revealed'].';}
.qpp-style'.$id.' div.rangeslider__handle {background: '.$style['handle-background'].';border: 1px solid '.$style['handle-border'].';width: '.$handle.'em;height: '.$handle.'em;position: absolute;top: -0.5em;-webkit-border-radius:'.$style['handle-colours'].'%;-moz-border-radius:'.$style['handle-corners'].'%;-ms-border-radius:'.$style['handle-corners'].'%;-o-border-radius:'.$style['handle-corners'].'%;border-radius:'.$style['handle-corners'].'%;}
.qpp-style'.$id.' div.qpp-slideroutput{font-size:'.$style['output-size'].';color:'.$style['output-colour'].';}';
        
    $code .= ".qpp-style".$id." {width:".$width.";max-width:100%; }".$border.$corners.$header.$paragraph.$input.$required.$background.$submitbutton.$submithover.$couponbutton.$slider;
    $code  .= '.qpp-style'.$id.' input#qpptotal {font-weight:bold;font-size:inherit;padding: 0;margin-left:3px;border:none;'.$bg.'}';
    if ($style['use_custom'] == 'checked') $code .= $style['custom'];
    }
    echo $code;
?>