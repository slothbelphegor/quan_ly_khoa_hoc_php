
<body>
<section class="footer">
        
        <div class="box-container">
            
            <div class="box">
                <h3>Quick links</h3>
                <a href="index.php"><i class="fas fa-angle-right"></i>Trang chủ</a>
                <a href="courses_management.php"><i class="fas fa-angle-right"></i>Khoá học</a>
                <a href="user_orders.php"><i class="fas fa-angle-right"></i>Lịch sử</a>
            </div>
            
            <div class="box">
                <h3>Extra links</h3>
                <a href="#"><i class="fas fa-angle-right"></i>Ask questions</a>
                <a href="#"><i class="fas fa-angle-right"></i>About us</a>
                <a href="#"><i class="fas fa-angle-right"></i>Privacy policy</a>
                <a href="#"><i class="fas fa-angle-right"></i>Terms of use</a>
            </div>
            
            <div class="box">
                <h3>Contact info</h3>
                <a href="#"><i class="fas fa-phone"></i>012-345-6789</a>
                <a href="#"><i class="fas fa-envelope"></i>test@gmail.com</a>
                <a href="#"><i class="fas fa-map"></i>012-345-6789</a>
            </div>
        
            <div class="box">
                <h3>Contact info</h3>
                <a href="#"><i class="fab fa-facebook"></i>Facebook</a>
                <a href="#"><i class="fab fa-instagram"></i>Instagram</a>
                <a href="#"><i class="fab fa-twitter"></i>X</a>
                <a href="#"><i class="fab fa-linkedin"></i>Linkedin</a>
            </div>        

        </div>

        <div class="credit"> Created by <span>Nhóm 2</span> | All rights reserved! </div>
        
    </section>       
</body>

<link rel="stylesheet" href="css/style2.css">   
<marquee direction="left"><img src="images/flipped felix.gif" width="125"></marquee>
    
    














































<style>
.footer{
    /* background-color: gray; */
    background-size: 100%;
    background-position: center;
    background-attachment: fixed;
    
}

.footer .box-container{
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.footer .box-container .box h3{
    font-size: 1.5rem;
    padding-bottom: 1rem;
}

.footer .box-container .box a{
    font-size: 1rem;
    padding-bottom: 1rem;
    display: block;
}

.footer .box-container .box a i{
    margin-right: .5rem;
    transition: .2s linear;
}

.footer .box-container .box a:hover i{
    margin-right: 2rem;
}

.footer .credit{
    text-align: center;
    padding-top: 3rem;
    margin-top: 3rem;
    border-top: .1rem solid var(--black);
    font-size: 1.5rem;
    color: var(--black);
}

</style>