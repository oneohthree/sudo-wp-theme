<?php
/**
 * @package WordPress
 * @subpackage sudo
 * @since sudo v3.0
 */
if ( post_password_required() )
	return;
?>
	<?php if ( ! comments_open() && get_comments_number() ) : ?>

		<span class="no-comments">Comentarios desactivados</span>

	<?php else: ?>

	<?php endif; ?>

	<?php if ( have_comments() ) : ?>
		<ol id="comments" class="comment-list">
			<?php wp_list_comments('style=ol&type=comment&reply_text=Responder&avatar_size=0&callback=comment_markup'); ?>
		</ol>

	<?php endif; ?>

<?php

$comment_form_args = array(
	'id_form' => 'comment-form',
	'id_submit' => 'submit-comment',
	'title_reply' => 'Comparte tus impresiones',
	'title_reply_to' => 'Responder a %s',
	'cancel_reply_link' => 'Cancelar',
	'label_submit' => 'Enviar comentario',
	'comment_field' =>  '<label for="comment">Comentario</label>
	<textarea id="comment" name="comment" rows="6" aria-required="true" required></textarea>',
	'must_log_in' => '<p class="must-log-in">Debes <a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">identificarte</a> para escribir un comentario.</p>',
	'logged_in_as' => '<p class="logged-in-as">Conectado como <a href="' . admin_url( 'profile.php' ) . '">' . $user_identity . '</a>. <a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) . '">Salir</a></p>',
	'comment_notes_before' => '',
	'comment_notes_after' => '',
	'fields' => apply_filters( 'comment_form_default_fields', array(
		'author' =>
		'<label for="author">Nombre (requerido)</label>' .
		'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req = ( $req ? "aria-required='true'" : '' ) . ' required>',

		'email' =>
		'<label class="screen-reader" for="email">Email (requerido)</label>' .
		'<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" ' . $aria_req = ( $req ? "aria-required='true'" : '' ) . ' required>',
	)),
);
?>

<?php comment_form( $comment_form_args ); ?>
