<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="static/css/theme.css" type="text/css">
</head>

<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-gradient">
    <div class="container">
      <a class="navbar-brand" href="index.jsp">
        <i class="fa d-inline fa-lg fa-cloud"></i>
        <b>&nbsp;文件共享系统</b>
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
        <a class="btn navbar-btn ml-2 btn-light text-success" href="login.jsp">&nbsp;登录</a>
        <a class="btn navbar-btn ml-2 btn-light text-success" href="register.jsp">&nbsp;注册</a>
      </div>
    </div>
  </nav>
  <div class="py-5" style="background-image:url('static/pic/bg.jpg');background-repeat:no-repeat;">
    <div class="container">
      <div class="row">
        <div class="align-self-center col-md-6 text-white">
          <h1 class="text-center text-md-left display-3">文件共享系统</h1>
          <p class="lead">共享——互联网时代下的价值体现</p>
        </div>
        <div class="col-md-6">
          <div class="card bg-gradient" style="border-radius:25px;">
            <div class="card-body p-5">
              <h2 class="pb-3">注册</h2>
              <form action="signUp.action" method="post">
                <div class="form-group">
                  <label>邮箱</label>
                  <input class="form-control" placeholder="请输入邮箱"> </div>
                <div class="form-group">
                  <label>用户名</label>
                  <input class="form-control" placeholder="请输入用户名"> </div>
                <div class="form-group">
                  <label>密码</label>
                  <input type="password" class="form-control" placeholder="请输入密码"> </div>
                <div class="form-group">
                  <label>确认密码</label>
                  <input type="password" class="form-control" placeholder="请确认密码">
                </div>
                <div class="form-group">
                  <label>
                      <img style="border-radius: 5px;" src="createImageAction.action" onclick="this.src='createImageAction.action?'+ Math.random()" title="点击图片刷新验证码"/>
                  </label>
                  <input type="password" class="form-control" placeholder="请输入验证码">
                </div>
                <button type="submit" class="btn mt-2 btn-outline-dark">注册</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="bg-dark text-white py-2">
    <div class="container">
      <div class="row">
        <div class="col-md-12 mt-3 text-center">
          <p>© Copyright 2018 SuperJavaTeam - All rights reserved.</p>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>