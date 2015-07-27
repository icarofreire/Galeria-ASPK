<?php
    header("Content-type: text/css; charset: UTF-8");
    include("lib.php");
?>
@import url(http://fonts.googleapis.com/css?family=Lato:300,400,700,900);
body{background-color:#fff;font:normal 16px/22px Lato;color:#555;}
p {padding-bottom:20px;}
a:hover{text-decoration: none;}
.clearfix:after {
	content:".";
	display:block;
	clear:both;
	visibility:hidden;
	line-height:0;
	height:0;
}
.clearfix {
	display:inline-block;
}
html[xmlns] .clearfix {
	display:block;
}
* html .clearfix {
	height:1%;
}
h1,h2,h3,h4,h5,h6{font-family: Lato;margin: 0;padding: 0;}
h1{font-weight:300;font-size: 60px;line-height: 80px;}
h2{font-weight:300;font-size: 40px;line-height:38px;margin-bottom:80px;}
h3{font-weight:300;font-size: 35px;line-height:38px;margin-bottom:40px;}

.spacer{padding: 100px 0;}
.center{text-align: center;}

.header-bg {background:url(<?php echo FOTO_CAPA; ?>) center fixed;background-size:cover; }
.header {background:rgba(0,0,0,0.8);position: absolute;top: 0;bottom: 0;left: 0;right: 0;}
.fullpage .container{display:table; height:inherit;}
.fullpage .absolute-center{display:table-cell;vertical-align: middle;}

.header h1.info {color:#fff;}
.header h1.info a{color:#fff;text-decoration: none;}
.header h1.info a u{text-decoration: none;}
.header h1.info a:hover u{text-decoration: underline;}
.header h1.info b{opacity:0.5;}
.header h1.info b span{font-weight:300;opacity:0.7;}
.header a.btn{color: #fff;border: 1px solid #fff; padding: 10px 25px;text-decoration: none;border-radius: 0; margin-top: 25px;margin-right: 25px; text-transform: uppercase;font-size:16px;}
.header a.btn:hover{background:rgba(0,0,0,0.5);transition: all 0.5s ease; }

.connect-icon{text-align: right;}
.connect-icon a{float: left;margin-left: 10px;}
.connect-icon a:hover{opacity: 0.5;transition: all 0.5s ease;}

.connect-icon a.behance{margin-top: -10px;}
.prof-links{margin: 250px 0 50px 0;}


.portfolio ul li{position: relative;}
.portfolio ul li .overlay{display: none;position: absolute;top: 0; right: 0; left: 0; bottom: 0; background:rgba(0,0,0,0.5); margin: 7px;}
.portfolio ul li:hover .overlay{display: block;}
.portfolio ul li .overlay span{position: absolute;width: 100%;text-align: center;top: 50%;}
.portfolio ul li .overlay span a{border: 1px solid #fff;width: auto;display: inline-block;padding: 8px 20px;color: #fff;background: rgba(0,0,0,0.6);letter-spacing: 2px;word-spacing: 5px;}
.portfolio ul li .overlay span a:hover{background: rgba(0,0,0,0.8);}



.testimonials-bg{background:url(images/testimonial-bg.jpg) center fixed #000;background-size:cover;}
.testimonials{background:rgba(0,0,0,0.9);color: #fff;}
.testimonials p{font-size: 26px;font-weight: 300;line-height: 35px;padding: 0 200px;}

#carousel-testimonials .arrow{position: absolute;color: #fff;top: 12%;background:none;font-size:35px;: }
#carousel-testimonials .arrow.left{left: 0;}
#carousel-testimonials .arrow.right{right: 0;}


.footer {	background-color:#eee;	color:#666;}

.toTop{position: fixed; bottom: 20px; right: 20px;color: #fff; font-size: 50px;padding:0 10px;background: rgba(0,0,0,0.5);}
.toTop:hover{opacity: 0.5;color: #fff;transition: all 0.5s ease;}

.contact-form input,.contact-form textarea{margin-bottom: 15px;font-size: 18px;height: auto;padding: 15px;font-weight: 300;border-radius: 0;}
.contact-form input.btn{width: 100%;background-color: #333;color: #fff; font-size: 23px;border: none;}



@media (max-width: 1200px){
		h1{font-size: 50px;line-height: 70px;}
		h2{font-size: 35px;margin-bottom: 50px;}
		h3{font-size: 25px;margin-bottom: 30px;}
		.spacer{padding: 70px 0;}

		.testimonials p{padding: 0 100px;}
}


@media (max-width: 768px){
	h1 {font-size: 40px;line-height: 60px;}
	h2{font-size: 30px;margin-bottom: 30px;}
	h3{font-size: 25px;margin-bottom: 25px;}
	.header .absolute-center {margin-top: 30%;}
}


@media (max-width: 767px){	
	h1 {font-size: 50px;line-height: 90px;}
	h2{font-size: 25px;margin-bottom: 25px;}
	.header a.btn{font-size: 12px;margin-right: 18px;}
	.header a.btn:last-child{margin-right: 0;}
	.header .absolute-center {margin-top: 10%;}
	.prof-links{margin: 60px 0 10px 0; width: 100%;}
	.connect-icon a{margin:0 10px 0 0;}
	.social {width: 100%;}
	.spacer{padding: 30px 0;}
}

@media (max-width: 600px){
	h1 {font-size: 27px;line-height: 40px;}
	.testimonials p{padding: 0;font-size: 14px;line-height: 20px;}
}
