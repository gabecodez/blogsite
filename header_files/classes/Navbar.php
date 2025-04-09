<?php
// File: Navbar.php
// Author: Gabriel Sullivan
// Purpose: Object-oriented navigation bar for BlueSky Homesteading

require_once $_SERVER['DOCUMENT_ROOT'] . '/../../header_files/blueskyhomesteading/config.php';

class Navbar
{
    protected $shop_conn;
    protected $session_id;
    protected $cartCount;

    public function __construct($shop_conn, $session_id)
    {
        $this->shop_conn = $shop_conn;
        $this->session_id = $session_id;
        $this->cartCount = $this->getCartCount();
    }

    /**
     * Retrieves the total number of items in the cart for the current session.
     */
    protected function getCartCount()
    {
        $result = $this->shop_conn->fetchAll(
            "SELECT SUM(quantity) AS total_items FROM cart WHERE session_id = ?",
            [$this->session_id]
        );
        return $result[0]['total_items'] ?? 0;
    }

    /**
     * Renders the full navbar HTML.
     */
    public function render()
    {
        ob_start();
?>
        <nav class="navbar homepage" id="navbar" aria-label="Main Navigation">
            <div class="navbar-indent">
                <div class="navbar-brand">
                    <a href="https://www.blueskyhomesteading.com" aria-label="BlueSky Homesteading Home">
                        <img src="https://www.blueskyhomesteading.com/images/logos/blueskylogoblack.svg" alt="BlueSky Homesteading Logo" class="logo">
                    </a>
                    <span class="tagline">Explore Nature’s gifts for health.</span>
                </div>
                <div class="navbar-toggle" id="mobile-menu" aria-expanded="false" aria-controls="mobile-nav-panel" aria-label="Toggle navigation">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
                <ul class="navbar-menu">
                    <?php
                    echo $this->renderMenuItem(
                        "Blog",
                        "https://www.blueskyhomesteading.com/blog",
                        [
                            "Skincare" => "https://www.blueskyhomesteading.com/blog/skincare",
                            "Resources" => "https://www.blueskyhomesteading.com/blog/resources",
                            "Chickens" => "https://www.blueskyhomesteading.com/blog/chickens"
                        ],
                        true
                    );
                    ?>
                    <?php echo $this->renderMenuItem("Shop", "https://www.blueskyhomesteading.com/shop"); ?>
                    <?php echo $this->renderMenuItem(
                        "Search",
                        "https://www.blueskyhomesteading.com/search",
                        [],
                        false,
                        true
                    ); ?>
                    <?php if ($this->cartCount > 0): ?>
                        <?php echo $this->renderMenuItem("Cart (" . $this->cartCount . ")", "https://www.blueskyhomesteading.com/shop/cart"); ?>
                    <?php endif; ?>
                </ul>
            </div>
            <?php echo $this->renderMobilePanel(); ?>
        </nav>
    <?php
        return ob_get_clean();
    }

    /**
     * Renders a single menu item. If dropdown items are provided,
     * it will render a submenu.
     *
     * @param string $title The title of the menu item.
     * @param string $url The URL the menu item points to.
     * @param array $dropdownItems Optional associative array of submenu items (title => URL).
     * @param bool $hasDropdown Whether to add dropdown attributes and icon.
     * @param bool $isIcon Whether to include an icon (for example, the search icon).
     * @return string HTML markup for the menu item.
     */
    protected function renderMenuItem($title, $url, $dropdownItems = [], $hasDropdown = false, $isIcon = false)
    {
        // Set the icon if needed.
        $icon = '';
        if ($hasDropdown) {
            $icon = ' <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black">
                        <path d="M200-200v-400h80v264l464-464 56 56-464 464h264v80H200Z" />
                    </svg>';
        } elseif ($isIcon && $title === "Search") {
            $icon = ' <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="20px" viewBox="0 -960 960 960" width="20px" fill="black">
                        <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                    </svg>';
        }

        ob_start();
    ?>
        <li class="navbar-item <?php echo (!empty($dropdownItems) ? 'dropdown' : ''); ?>">
            <a href="<?php echo $url; ?>" class="nav-link <?php echo (!empty($dropdownItems) ? 'dropdown-toggle' : ''); ?>" <?php echo (!empty($dropdownItems) ? 'aria-haspopup="true" aria-expanded="false"' : ''); ?>>
                <span><?php echo $title; ?></span>
                <?php echo $icon; ?>
            </a>
            <?php if (!empty($dropdownItems)): ?>
                <ul class="dropdown-menu">
                    <?php foreach ($dropdownItems as $subTitle => $subUrl): ?>
                        <li><a href="<?php echo $subUrl; ?>"><?php echo $subTitle; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </li>
    <?php
        return ob_get_clean();
    }

    /**
     * Renders the mobile navigation panel.
     */
    protected function renderMobilePanel()
    {
        ob_start();
    ?>
        <div class="mobile-nav-panel" id="mobile-nav-panel">
            <button class="close-panel" aria-label="Close navigation">
                <span class="x-bar"></span>
                <span class="x-bar"></span>
            </button>
            <ul>
                <li>
                    <a href="https://www.blueskyhomesteading.com/blog">Blog</a>
                    <ul>
                        <li>
                            <a href="https://www.blueskyhomesteading.com/blog/skincare">
                                <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="black">
                                    <path d="m576-192-51-51 129-129H240v-444h72v372h342L525-573l51-51 216 216-216 216Z" />
                                </svg>
                                Skincare
                            </a>
                        </li>
                        <li>
                            <a href="https://www.blueskyhomesteading.com/blog/resources">
                                <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="black">
                                    <path d="m576-192-51-51 129-129H240v-444h72v372h342L525-573l51-51 216 216-216 216Z" />
                                </svg>
                                Resources
                            </a>
                        </li>
                        <li>
                            <a href="https://www.blueskyhomesteading.com/blog/chickens">
                                <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="black">
                                    <path d="m576-192-51-51 129-129H240v-444h72v372h342L525-573l51-51 216 216-216 216Z" />
                                </svg>
                                Chickens
                            </a>
                        </li>
                    </ul>
                </li>
                <li><a href="https://www.blueskyhomesteading.com/shop">Shop Skincare</a></li>
                <li>
                    <a href="https://www.blueskyhomesteading.com/search">
                        <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="black">
                            <path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-400q75 0 127.5-52.5T560-580q0-75-52.5-127.5T380-760q-75 0-127.5 52.5T200-580q0 75 52.5 127.5T380-400Z" />
                        </svg>
                        Search
                    </a>
                </li>
                <?php if ($this->cartCount > 0): ?>
                    <li>
                        <a href="https://www.blueskyhomesteading.com/shop/cart">
                            <svg style="vertical-align: middle;" xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="black">
                                <path d="M280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM246-720l96 200h280l110-200H246Zm-38-80h590q23 0 35 20.5t1 41.5L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68-39.5t-2-78.5l54-98-144-304H40v-80h130l38 80Z" />
                            </svg>
                            Cart
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
<?php
        return ob_get_clean();
    }
}
