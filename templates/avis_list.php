<div class="container mt-5">
    <h2>Avis des visiteurs</h2>
    <?php if (!empty($avis)): ?>
        <ul class="list-group">
            <?php foreach ($avis as $avisItem): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($avisItem['pseudo']) ?></strong> :
                    <?= htmlspecialchars($avisItem['avis']) ?> 
                    <span class="text-warning">
                        <?= str_repeat('★', (int) $avisItem['rating']) ?>
                    </span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Aucun avis pour le moment.</p>
    <?php endif; ?>
</div>
