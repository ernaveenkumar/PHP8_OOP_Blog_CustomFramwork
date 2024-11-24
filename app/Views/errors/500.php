<h1>Opps! Something went wrong</h1>
<p><?php htmlspecialchars($errorMessage) ?></p>

  <?php if ($isDebug) : ?>
    <h2>Stack Trace</h2>
    <pre><?php htmlspecialchars($trace) ?></pre>
  <?php else: ?>    
    <p>
      <a href="/">Return to hompage</a>
    </p>
  <?php endif; ?>