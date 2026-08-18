<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class StudentMiddleware
{
    public function handle($next)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['student_access']) || $_SESSION['student_access'] !== true) {
            http_response_code(403);
            echo '<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Access Denied</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
body{font-family:"Plus Jakarta Sans",sans-serif;background:hsl(270,50%,97%);min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem}
.box{background:#fff;border:1px solid hsl(270,30%,90%);border-radius:20px;padding:3rem 2.5rem;max-width:440px;width:100%;text-align:center;position:relative;overflow:hidden}
.box::before{content:"";position:absolute;top:0;left:0;right:0;height:5px;background:linear-gradient(90deg,hsl(0,75%,60%),hsl(0,60%,42%))}
.icon{width:80px;height:80px;background:hsl(0,90%,95%);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:36px;margin:0 auto 1.5rem;animation:shake .5s ease both}
@keyframes shake{0%,100%{transform:translateX(0)}20%{transform:translateX(-6px)}40%{transform:translateX(6px)}60%{transform:translateX(-4px)}80%{transform:translateX(4px)}}
.code{font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.12em;color:hsl(0,65%,50%);margin-bottom:.5rem}
h1{font-size:1.6rem;font-weight:800;letter-spacing:-.02em;color:hsl(270,20%,15%);margin-bottom:.75rem}
p{font-size:.95rem;color:hsl(270,10%,40%);line-height:1.65;margin-bottom:2rem}
a{display:inline-flex;align-items:center;gap:.4rem;background:linear-gradient(135deg,hsl(270,75%,65%),hsl(270,60%,44%));color:#fff;text-decoration:none;font-weight:700;font-size:.9rem;padding:.75rem 1.75rem;border-radius:10px;transition:transform .18s,box-shadow .18s;box-shadow:0 4px 16px hsl(270,60%,70%,.4)}
a:hover{transform:translateY(-2px);box-shadow:0 8px 24px hsl(270,60%,60%,.45)}
</style>
</head>
<body>
<div class="box">
<div class="icon">🚫</div>
<div class="code">403 – Access Denied</div>
<h1>You can\'t go there yet</h1>
<p>You must visit the <strong>Student Home</strong> page first before accessing the Student Profile.</p>
<a href="' . site_url('student') . '">← Go to Student Home</a>
</div>
</body>
</html>';
            exit;
        }

        return $next();
    }
}
?>
