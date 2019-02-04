<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style')
    );
}

/*既存の「メール」「URL」の記入欄を表示させない*/
 function my_comment_form_fields( $fields){
    unset( $fields['email']);   
    unset( $fields['url']);     
    return $fields;
}
add_filter( 'comment_form_default_fields', 'my_comment_form_fields');


/*既存の但し書き「メールアドレスが公開されることはありません」を表示させない｡*/
add_filter( "comment_form_defaults", "my_comment_notes_before");
function my_comment_notes_before( $defaults){
    $defaults['comment_notes_before'] = '';
    return $defaults;
}
add_filter( "comment_form_defaults", "my_comment_notes_after");
function my_comment_notes_after( $defaults){
    $defaults['comment_notes_after'] = '';
    return $defaults;
}


/*「コメントを残す」の文言を「公開まで､少し時間がかかりまーす｡」に変更｡*/
add_filter( 'comment_form_defaults', 'my_title_reply');
function my_title_reply( $defaults){
    $defaults['title_reply'] = '公開に少し時間がかかります';
    return $defaults;
}


/*名前を「とく名でもOK!」､「コメントを送信する」を「送信」に変えた*/
function my_comment_form_defaults( $defaults ) {
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$html_req = ( $req ? " required='required'" : '' );
	$defaults['fields']['author'] = 
		'<p class="comment-form-author">' . '<label for="author">匿名でOK !' . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
		'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $html_req . ' /></p>';
	$defaults['label_submit'] = '送る';
	return $defaults;
}
add_filter( 'comment_form_defaults', 'my_comment_form_defaults' );



