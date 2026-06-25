<?php
DB::statement("ALTER TABLE contacts MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'pending'");
echo "Done";
