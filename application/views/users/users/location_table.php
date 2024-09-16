<?php if (!empty($locations)): ?>
    <?php $i = 1; ?>
    <?php foreach ($locations as $location): ?>
        <tr>
            <td><?= $i; ?></td>
            <td><?= $location->admin_name; ?> ( <?= $location->mobile; ?> )</td>
            <td><?= $location->role_name; ?></td>
            <td><?= $location->country_name; ?> ( <?= $location->country_code; ?> )</td>
            <td><?= $location->state_name; ?> ( <?= $location->state_code; ?> )</td>
            <td><?= $location->commissionaires_name; ?> ( <?= $location->commissionaires_code; ?> )</td>
            <td><?= $location->district_name; ?> ( <?= $location->district_code; ?> )</td>
            <td><?= $location->tehsil_name; ?> ( <?= $location->tehsil_code; ?> )</td>
            <td><?= $location->pincode; ?></td>
            <td>
                <a href="javascript:void(0)" class="update-action" data-id="<?= $location->id; ?>" title="Update">
                    <i class="la la-pencil-square"></i>
                </a>
                <a href="javascript:void(0)" class="delete-action" data-id="<?= $location->id; ?>" title="Delete">
                    <i class="la la-trash"></i>
                </a>
            </td>
        </tr>
        <?php $i++; ?>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="10">No data available</td>
    </tr>
<?php endif; ?>
