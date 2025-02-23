<?php
class Breadcrumb {
    private array $crumbs = [];

    public function addCrumb(string $label, string $url = ''): void {
        $this->crumbs[] = [
            'label' => htmlspecialchars($label),
            'url' => $url ? htmlspecialchars($url) : null
        ];
    }

    public function render(): void {
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
?>