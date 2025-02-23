<?php
class SocialShare {
    private string $title;
    private string $url;
    private string $description;
    private string $image;

    public function __construct($title, $url, $description, object $image = null) {
        $this->title = $title;
        $this->url = $url;
        $this->description = $description;
        $this->image = !empty($image->url) ? $image->url : 'https://www.blueskyhomesteading.com/images/social_media_previews/basic_white_bg_w_logo.jpeg';
    }

    private function generateButton(string $class, string $href, string $icon): string {
        return '<a class="share-btn ' . $class . '" href="' . $href . '" target="_blank">
                    <i class="' . $icon . '"></i>
                </a>';
    }

    public function render(): void {
        $buttons = [
            'facebook' => $this->generateButton('facebook', 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($this->url), 'fab fa-facebook-f'),
            'twitter' => $this->generateButton('twitter', 'https://twitter.com/intent/tweet?text=' . urlencode($this->title . ' ' . $this->url), 'fab fa-twitter'),
            'bluesky' => $this->generateButton('bluesky', 'https://bsky.app/share?text=' . urlencode($this->title) . '&url=' . urlencode($this->url), 'fa-solid fa-cloud'),
            'instagram' => $this->generateButton('instagram', 'https://www.instagram.com', 'fab fa-instagram'),
            'pinterest' => $this->generateButton('pinterest', 'https://pinterest.com/pin/create/button/?url=' . urlencode($this->url) . '&media=' . urlencode($this->image) . '&description=' . urlencode($this->description), 'fab fa-pinterest'),
            'flipboard' => $this->generateButton('flipboard', 'https://share.flipboard.com/bookmarklet/popout?v=2&url=' . urlencode($this->url) . '&title=' . urlencode($this->title), 'fab fa-flipboard'),
            'reddit' => $this->generateButton('reddit', 'https://www.reddit.com/submit?url=' . urlencode($this->url) . '&title=' . urlencode($this->title), 'fab fa-reddit-alien'),
            'mail' => $this->generateButton('mail', 'mailto:?subject=' . urlencode($this->title) . '&body=' . urlencode($this->description . ' ' . $this->url), 'fas fa-envelope'),
        ];

        echo '<div class="share-buttons">' . implode('', $buttons) . '</div>';
    }
}
?>