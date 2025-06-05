<!DOCTYPE html>
<html>
<head>
    <title>SQL Admin Panel</title>
    <link rel="stylesheet" href="../../../css/admin.css">
</head>
<body>
    <h1>SQL Admin Panel</h1>
    <form method="GET">
        <select name="table" onchange="this.form.submit()">
            <?php foreach ($tables as $tbl): ?>
                <option value="<?= $tbl ?>" <?= $tbl == $current_table ? 'selected' : '' ?>><?= $tbl ?></option>
            <?php endforeach; ?>
        </select>
    </form>

    <h2>Table: <?= htmlspecialchars($current_table) ?></h2>
    <table>
        <thead>
            <tr>
                <?php foreach ($columns as $col): ?>
                    <th><?= $col['Field'] ?></th>
                <?php endforeach; ?>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $rows->fetch_assoc()): ?>
                <tr>
                    <form action="../controllers/update.php" method="POST">
                        <?php foreach ($columns as $col): ?>
                            <td>
                                <?php
                                $field = $col['Field'];
                                $value = $row[$field];
                                $enums = getEnumValues($conn, $current_table, $field);
                                if ($enums): ?>
                                    <select name="<?= $field ?>">
                                        <?php foreach ($enums as $opt): ?>
                                            <option value="<?= $opt ?>" <?= $opt == $value ? 'selected' : '' ?>><?= $opt ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                <?php else: ?>
                                    <input type="text" name="<?= $field ?>" value="<?= htmlspecialchars($value) ?>">
                                <?php endif; ?>
                            </td>
                        <?php endforeach; ?>
                        <td>
                            <input type="hidden" name="table" value="<?= $current_table ?>">
                            <input type="hidden" name="key" value="<?= $columns[0]['Field'] ?>">
                            <input type="hidden" name="id" value="<?= $row[$columns[0]['Field']] ?>">
                            <button type="submit">Update</button>
                            <a href="../controllers/delete.php?table=<?= $current_table ?>&key=<?= $columns[0]['Field'] ?>&id=<?= $row[$columns[0]['Field']] ?>">Delete</a>
                        </td>
                    </form>
                </tr>
            <?php endwhile; ?>
            <tr>
                <form action="../controllers/add.php" method="POST">
                    <?php foreach ($columns as $col): ?>
                        <td>
                            <?php
                            $field = $col['Field'];
                            if ($col['Extra'] == 'auto_increment') {
                                echo "<i>Auto</i>";
                                continue;
                            }
                            if($col['Default'] == 'current_timestamp()') {
                                echo "<i>Current time</i>";
                                continue;
                            }
                            $enums = getEnumValues($conn, $current_table, $field);
                            if ($enums): ?>
                                <select name="<?= $field ?>">
                                    <?php foreach ($enums as $opt): ?>
                                        <option value="<?= $opt ?>"><?= $opt ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php else: ?>
                                <input type="text" name="<?= $field ?>">
                            <?php endif; ?>
                        </td>
                    <?php endforeach; ?>
                    <td>
                        <input type="hidden" name="table" value="<?= $current_table ?>">
                        <button type="submit">Add</button>
                    </td>
                </form>
            </tr>
        </tbody>
    </table>
</body>
</html>

