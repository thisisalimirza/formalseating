<?php
session_start();
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Check if user is authenticated and is admin
if (!isAuthenticated() || !getCurrentUser()['is_admin']) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bulk Import Approved Emails - UCHC Formal 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-gray-900 mb-6">Bulk Import Approved Emails</h1>
            
            <div class="mb-6">
                <label for="emails" class="block text-sm font-medium text-gray-700 mb-2">
                    Enter Emails (one per line)
                </label>
                <textarea id="emails" rows="10" 
                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="email1@example.com&#10;email2@example.com&#10;email3@example.com"></textarea>
            </div>

            <div class="flex justify-between items-center">
                <button id="importBtn" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Import Emails
                </button>
                <a href="admin.php" class="text-sm text-gray-600 hover:text-gray-900">Back to Admin Panel</a>
            </div>

            <!-- Results section -->
            <div id="results" class="mt-6 hidden">
                <h2 class="text-lg font-medium text-gray-900 mb-3">Import Results</h2>
                <div class="bg-gray-50 rounded-md p-4">
                    <dl class="grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Processed</dt>
                            <dd id="totalCount" class="mt-1 text-lg font-semibold text-gray-900">0</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Successfully Added</dt>
                            <dd id="successCount" class="mt-1 text-lg font-semibold text-green-600">0</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duplicates</dt>
                            <dd id="duplicateCount" class="mt-1 text-lg font-semibold text-yellow-600">0</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Invalid Emails</dt>
                            <dd id="invalidCount" class="mt-1 text-lg font-semibold text-red-600">0</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('importBtn').addEventListener('click', async function() {
            const emailsText = document.getElementById('emails').value;
            const emails = emailsText.split('\n')
                .map(email => email.trim())
                .filter(email => email !== '');

            if (emails.length === 0) {
                alert('Please enter at least one email address');
                return;
            }

            try {
                const response = await fetch('api/bulk_add_approved_emails.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(emails)
                });

                const result = await response.json();
                
                if (result.success) {
                    // Show results
                    document.getElementById('results').classList.remove('hidden');
                    document.getElementById('totalCount').textContent = result.stats.total;
                    document.getElementById('successCount').textContent = result.stats.added;
                    document.getElementById('duplicateCount').textContent = result.stats.duplicates;
                    document.getElementById('invalidCount').textContent = result.stats.invalid;
                } else {
                    throw new Error(result.error || 'Import failed');
                }
            } catch (error) {
                alert('Error importing emails: ' + error.message);
            }
        });
    </script>
</body>
</html> 