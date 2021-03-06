# PHP_Framework

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
自行封装的一套基于MVC模式的PHP框架

## 目录介绍

1. application：应用目录，使用者可以创建自己的应用目录，并且支持在框架下部署多个应用。

 * configures：当前应用配置文件夹，用户可以在这里进行数据库的相关配置和网站的相关配置。

 * controllers：控制器文件夹，用户可以在此文件夹下定义自己的控制器和方法。

 * data：应用数据文件夹，保存当前应用的缓存和日志数据。

 * model：模型文件夹，用户可以在此处定义自己的模型和方法。

 * views：试图文件夹，用户可以在此处定义自己的视图文件。

2. core：框架核心类文件，包括框架的核心类，加载器类，父控制器类，父模型类等文件。

 * base.class.php：父控制器，整个框架的控制器继承自该控制器，进行数据库类，缓存类，加载器类的初始化工作。

 * core.class.php：框架的核心类，加载父控制器便于应用中继承，加载系统的类库和函数库，调用base类完成相关函数和类库的初始化，该类由入口文件调用并实例化，对输入的请求进行处理并路由到相关控制器。

 * loader.class.php：加载器类，提供加载模型，视图，类库，函数库的功能，加载模型，类库和函数库为动态添加，加载后其对象自动成为父控制器对象的属性。

 * mbase.class.php：父模型类，整个框架的模型类继承自该模型，进行数据库操作之前的相关初始化操作。

3. lib：框架类库和辅助函数所在目录，包含了加载器类能够动态加载的类和辅助函数。

 * 类库：包括缓存类，日历类，验证码类，数据库类，分页类，图像处理类，文件上传类。

 * 函数库：包括页面重定向函数，控制器路由函数。

4. public：公共资源文件夹，包括前台的资源以及用于保存上传文件的目录。
 * css：前台css文件保存目录。

 * js：前台js文件保存目录。

 * images：前台图片保存目录。

 * uploads：文件上传保存目录。

5. index.php：框架入口文件，定义了框架的相关常量，包括入口标识，应用目录，MVC的相关目录，在该文件中进行核心类的实例化和调用。

## 使用手册 
