<?php
// Breadcrumb.php
// Purpose: Handles the rendering of a breadcrumb object to the page
class Breadcrumb
{
    private array $crumbs = []; // the various links

    // Constructor
    // Input: array $initialCrumbs - any initial crumbs as an array
    public function __construct(array $initialCrumbs = [])
    {
        // loop through the crumbs
        foreach ($initialCrumbs as $crumb) {
            if (isset($crumb['label'])) {
                $this->addCrumb($crumb['label'], $crumb['url'] ?? ''); // add the crumb if it isn't empty
            }
        }
    }

    // Function name: addCrumb
    // Purpose: a function for easily adding crumbs
    // Input: string $label - the text of the link
    //        string $url - the actual URL
    // Output: none
    // Raises: none
    public function addCrumb(string $label, string $url = ''): void
    {
        $this->crumbs[] = [
            'label' => htmlspecialchars($label),
            'url' => $url ? htmlspecialchars($url) : null
        ];
    }

    // Function name: render
    // Purpose: renders the crumbs to the screen as a list
    public function render(): void
    {
        if (empty($this->crumbs)) return;

        echo '<nav aria-label="breadcrumb"><ol>';
        $lastIndex = count($this->crumbs) - 1;

        foreach ($this->crumbs as $index => $crumb) {
            echo '<li' . ($index === $lastIndex ? ' aria-current="page"' : '') . '>';
            if ($crumb['url'] && $index !== $lastIndex) {
                echo '<a href="' . $crumb['url'] . '">' . $crumb['label'] . '</a>';
            } else {
                echo $crumb['label'];
            }
            echo '</li>';
        }

        echo '</ol></nav>';
    }
}
