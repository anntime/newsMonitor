<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>密码重置</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <link href="assets/css/docs.css" rel="stylesheet">
    <link href="assets/js/google-code-prettify/prettify.css" rel="stylesheet">

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="assets/ico/favicon.png">

  </head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">

    <!-- Navbar
    ================================================== -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="../index.html">智能信息提醒平台</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active">
                <a href="../index.html">主  页</a>
              </li>
              <li class="">
                <a href="./index.php">用户登录</a>
              </li>
              <li class="">
                <a href="./register.html">用户注册</a>
              </li>
              <li class="">
                <a href="./about.html">关于我们</a>
              </li>
              <li class="">
                <a href="./feedback.php">用户反馈</a>
              </li>
              
            </ul>
          </div>
        </div>
      </div>
    </div>

<!-- Masthead
================================================== -->
<header class="jumbotron subhead" id="overview">
  <div class="container">
    <p class="lead"><a>密码重置</a></p>
  </div>
</header>


  <div class="container">

    <!-- Docs nav
    ================================================== -->
    <div class="row">
      <div class="span3 bs-docs-sidebar">
       
      </div>
      <div class="span9">
      <div class="span9">

          <form class="bs-docs-example form-horizontal" action="creatcode.php" method="POST">
            <div class="control-group">
              <label class="control-label" for="inputIcon">请输入登录时用户名：</label>

              <div class="controls">

                <div class="input-prepend">

                  <span class="add-on"><i class="icon-user"></i></span>

                  <input class="span3" id="UserName" name="UserName" type="text"placeholder="用户名">

                </div>

              </div>

            </div>
            <label class="control-label" for="inputIcon">请输入注册时绑定邮箱：</label>

              <div class="controls">

                <div class="input-prepend">

                  <span class="add-on"><i class="icon-envelope"></i></span>

                  <input class="span3" id="Email" name="Email" type="email" placeholder="邮箱">

                </div>

              </div>

            <div class="control-group">
              <div class="controls">
             <h6>&nbsp;&nbsp;将向您邮箱里发送验证邮件，请查收！</h6>
             <button type="submit" class="btn">确认重置</button>
                
              </div>
            </div>
          </form>
        </div>

        



      </div>
    </div>

  </div>



    <!-- Footer
    ================================================== -->
    <footer class="footer">
      <div class="container">
        <p>欢迎批评指正   我们的成长源于您的支持！</p>
        <p>济宁学院计算机科学系人工智能实验室</p>
        <p>Copyright © 2103 the Smart Alert Platform </p>        
      </div>
    </footer>



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script type="text/javascript" src="assets/js/widgets.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/bootstrap-affix.js"></script>

    <script src="assets/js/holder/holder.js"></script>
    <script src="assets/js/google-code-prettify/prettify.js"></script>

    <script src="assets/js/application.js"></script>



  </body>
</html>
