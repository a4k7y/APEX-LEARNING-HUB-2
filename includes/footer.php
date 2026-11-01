<?php if (!empty($useVisualTheme)): ?>
    </main>
    <?php
    $visualBase = $siteRootPath ?? '../';
    $visualBase .= 'visual/';
    if (isset($extraJs)):
    ?>
        <?php foreach ((array) $extraJs as $script): ?>
            <script src="<?= htmlspecialchars($script) ?>"></script>
        <?php endforeach; ?>
    <?php
    endif;
    require __DIR__ . '/../visual/_partials/foot.php';
    ?>
<?php else: ?>
    </main>
    <footer class="app-footer">
        <div class="footer-content">
            <div class="footer-left">
                <strong>APEX Learning Hub</strong> &copy; <?= date('Y') ?> &bull; All Rights Reserved.
            </div>
            <div class="footer-right">
                <span class="text-muted">Connected to XAMPP &bull; PHP <?= phpversion() ?> &bull; MySQL</span>
            </div>
        </div>
    </footer>
    <?php if (isset($extraJs)): ?>
        <?php foreach ((array) $extraJs as $script): ?>
            <script src="<?= htmlspecialchars($script) ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
    <script src="<?= htmlspecialchars(($siteRootPath ?? '../') . 'visual/js/visual.js?v=202610291931') ?>"></script>
</body>
</html>
<?php endif; ?>
