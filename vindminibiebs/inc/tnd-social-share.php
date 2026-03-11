<?php 
function tnd_share_buttons() {
    if ( ! is_singular( 'post' ) ) {
        return '';
    }

    $url   = urlencode( get_permalink() );
    $title = urlencode( get_the_title() );

    $html  = '<div class="tnd-share">';
    $html .=   '<div class="tnd-share__buttons">';
    $html .=     '<a class="tnd-share__btn tnd-share__btn--facebook" href="https://www.facebook.com/sharer.php?u=' . $url . '&t=' . $title . '" target="_blank" rel="noopener noreferrer">                <svg class="tnd-icon" height="50" viewBox="0 0 30 30" width="50" xmlns="http://www.w3.org/2000/svg">
                <path d="M18.5 10.3h-2.2c-.1 0-.3.1-.4.2-.1.2-.2.4-.2.6v1.6h2.8l-.4 2.3h-2.4v7H13v-7h-2.4v-2.3H13v-1.4c0-1 .3-1.8.9-2.5.6-.7 1.4-1.1 2.3-1.1h2.2v2.6z"></path>
                </svg></a>';
    $html .=     '<a class="tnd-share__btn tnd-share__btn--x" href="https://twitter.com/intent/tweet?url=' . $url . '&text=' . $title . '" target="_blank" rel="noopener noreferrer"> <svg class="tnd-icon" height="50" viewBox="0 0 30 30" width="50" xmlns="http://www.w3.org/2000/svg">
                    <path d="M21.1 12.3v.4c0 1-.2 2-.5 3-.4 1-.9 1.9-1.6 2.7-.7.8-1.6 1.5-2.6 2s-2.2.8-3.6.8c-.8 0-1.6-.1-2.4-.4s-1.5-.6-2.1-1h.8c.7 0 1.3-.1 2-.3s1.2-.5 1.7-.9c-.7 0-1.2-.2-1.7-.6s-1.1-1-1.3-1.6h1c.1 0 .3 0 .4-.1-.7-.1-1.2-.5-1.7-1s-.7-1.2-.7-1.9c.2.1.4.2.6.2.2.1.5.1.7.1-.4-.3-.7-.6-.9-1.1-.2-.4-.4-.9-.4-1.4 0-.3 0-.5.1-.8.1-.3.2-.5.3-.7.7.9 1.6 1.6 2.7 2.2s2.2.9 3.4.9c0-.1-.1-.2-.1-.4v-.3c0-.8.3-1.5.9-2.1.6-.6 1.3-.9 2.1-.9.4 0 .8.1 1.2.2.4.2.7.4 1 .7.3-.1.6-.2 1-.3.3-.1.6-.3.9-.4-.1.3-.3.7-.5.9-.2.3-.5.5-.8.7.3 0 .6-.1.9-.2s.6-.2.8-.3c-.2.3-.4.6-.7.8-.3.6-.6.9-.9 1.1z"></path>
                </svg></a>';
    $html .=     '<a class="tnd-share__btn tnd-share__btn--linkedin" href="https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&title=' . $title . '" target="_blank" rel="noopener noreferrer"><svg class="tnd-icon" height="50" viewBox="0 0 30 30" width="50" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.3 11.4h3v9.8h-3zM9.8 10.2c-.5 0-.8-.1-1.1-.4s-.5-.7-.5-1.1c0-.4.1-.8.4-1.1s.7-.4 1.2-.4.9.1 1.1.4.4.6.4 1.1c0 .4-.1.8-.4 1.1s-.6.4-1.1.4zM22.4 21.2h-3v-5.4c0-.6-.1-1.1-.4-1.5s-.6-.6-1.2-.6c-.4 0-.7.1-1 .4-.3.2-.4.5-.6.8 0 .1-.1.2-.1.4v6h-3v-6.7-1.7-1.4h2.6l.2 1.3h.1c.2-.3.5-.7 1-1 .5-.4 1.1-.5 2-.5 1 0 1.8.3 2.5 1s1 1.8 1 3.2v5.7z"></path>
                </svg></a>';
    $html .=   '</div>';
    $html .= '</div>';

    return $html;
}
add_shortcode( 'tnd_share_buttons', 'tnd_share_buttons' );