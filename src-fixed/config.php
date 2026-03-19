<?php
// FIX: No hardcoded secrets — use environment variables
$aws_access_key = getenv('AWS_ACCESS_KEY') ?: '';
$aws_secret_key = getenv('AWS_SECRET_KEY') ?: '';
