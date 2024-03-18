<?php
//vẽ thanh điều hướng phân trang
class Pagination
{
    //biến chứa cấu hình
    private $config = [
        'total' => 0, //tổng số record
        'limit' => 0, //số record trên 1 trang
        'full' => true, //trang có đầy record không
        'querystring' => 'page', //biến trên url có thể là biến bất kì, sẽ trở thành biến page khi dc xử lý
        'search' => '' //cụm từ tìm kiếm
    ];

    public function getConfig()
    {
        return $this->config;
    }

    public function __construct($config = [])
    {
        $condition1 = isset($config['limit']) && $config['limit'] < 0;
        $condition2 = isset($config['total']) && $config['total'] < 0;
        if ($condition1 || $condition2) {
            die("Limit và total không dc nhỏ hơn 0");
        }
        // nếu user không truyền querystring
        if (!isset($config['querystring'])) {
            $config['querystring'] = 'page';
        }
        if (isset($_GET['search'])) {
            $config['search'] = $_GET['search'];
        } else $config['search'] = '';
        //đổi thành cấu hình do người dùng gửi vào
        $this->config = $config;
    }

    private function addSearchToUrl()
    {
        if (isset($_GET['search'])) {
            $search = urlencode($this->config['search']);
            return "&search=" . $search;
        }
        return '';
    }

    // tính tổng số trang
    private function gettotalPage()
    {
        $total = $this->config['total'];
        $limit = $this->config['limit'];
        return ceil($total / $limit);
    }
    // lấy trang hiện tại
    private function getCurrentPage()
    {
        //kiểm tra người dùng có truyền querysting vào không
        if (
            isset($_GET[$this->config['querystring']]) &&
            (int)$_GET[$this->config['querystring']] >= 1
        ) {
            $t = (int)$_GET[$this->config['querystring']];
            // kiểm tra người dùng có truyền vào số trang quá lớn không
            if ($t > $this->gettotalPage()) {
                return (int)$this->gettotalPage();
            } else {
                return $t;
            }
        } else {
            // không có querystring thì mặc định trang 1
            return 1;
        }
    }

    //lấy trang trước
    private function getPrePage()
    {
        if ($this->getCurrentPage() === 1) {
            return;
        }

        //PHP_SELF: lấy tên trang hiện hành
        return "<li class='item'><a class='text' href='" .
            $_SERVER['PHP_SELF'] . '?' .
            $this->config['querystring'] . '=' .
            ($this->getCurrentPage() - 1) .
            $this->addSearchToUrl() .
            "'>Previous</a></li>";
    }
    //lấy trang sau
    private function getNextPage()
    {
        if ($this->getCurrentPage() >= $this->gettotalPage()) {

            return;
        }
        return "<li class='item'><a class='text' href='" .
            $_SERVER['PHP_SELF'] . '?' . //PHP_SELF: lấy tên trang hiện hành
            $this->config['querystring'] . '=' .
            ($this->getCurrentPage() + 1) .
            $this->addSearchToUrl() .
            "'>Next</a></li>";
    }
    //vẽ thanh chuyển trang
    public function getPagination()
    {
        $data = '';
        // giới hạn hay không?
        if (isset($this->config['full']) && $this->config['full'] === false) {

            $data .= ($this->getCurrentPage() - 3) > 1 ?
                '<li class="item">...</li>' : '';
            $current = ($this->getCurrentPage() - 3) > 0 ?
                ($this->getCurrentPage() - 3) : 1;
            $total = (($this->getCurrentPage() + 3) > $this->gettotalPage() ?
                $this->gettotalPage() : ($this->getCurrentPage() + 3));
            for ($i = $current; $i <= $total; $i++) {
                if ($i === $this->getCurrentPage()) {
                    $data .= '<li class="item"><a href="#" class="text">' .
                        $i . '</a></li>';
                } else {
                    $data .= '<li class="item"><a class="text" href="' .
                        $_SERVER['PHP_SELF'] . "?" .
                        $this->config['querystring'] . '=' .
                        $i .
                        $this->addSearchToUrl() .
                        '">' . $i . '</a></li>';
                }
            }
            $data .= ($this->getCurrentPage() + 3) < $this->gettotalPage() ?
                '<li class="item">...</li>' : '';
        } else {
            for ($i = 1; $i <= $this->gettotalPage(); $i++) {
                if ($i === $this->getCurrentPage()) {
                    $data .= '<li class="item"><a class="text" href="#">' .
                        $i . '</a></li>';
                } else {
                    $data .= '<li class="item"><a class="text" href="' .
                        $_SERVER['PHP_SELF'] . '?' .
                        $this->config['querystring'] . '=' .
                        $i .
                        $this->addSearchToUrl() .
                        '">' . $i . '</a></li>';
                }
            }
        }

        return '<ul class="main-nav">' .
            $this->getPrePage() . // Liên kết đến trang trước
            $data . // Các liên kết đến các trang
            $this->getNextPage() . // Liên kết đến trang kế tiếp
            '</ul>';
    }

    public function getPagination1()
    {
        $data = '';
        $totalPages = $this->gettotalPage();
        $currentPage = $this->getCurrentPage();

        if (!$this->config['full']) {
            $data .= $this->getPageLink(1);
        }

        $startPage = max(2, $currentPage - 2);
        $endPage = min($totalPages - 1, $currentPage + 2);

        if ($startPage > 2 && !$this->config['full']) {
            $data .= '<li class="item">...</li>';
        }

        for ($i = $startPage; $i <= $endPage; $i++) {
            $data .= $this->getPageLink($i);
        }

        if ($endPage < $totalPages - 1 && !$this->config['full']) {
            $data .= '<li class="item">...</li>';
        }

        if (!$this->config['full']) {
            $data .= $this->getPageLink($totalPages);
        }


        return '<ul class="main-nav">' .
            $this->getPrePage() .
            $data .
            $this->getNextPage() .
            '<li class="item"><form action="' . $_SERVER['PHP_SELF'] . '" method="GET">' .
            '<input type="text" name="' . $this->config['querystring'] . '" class="page-input" value="' . $currentPage . '">' .
            '<input type="submit" value="Go" class="go-button"></form></li>' .
            '</ul>';
    }

    private function getPageLink($page)
    {
        if ($page == $this->getCurrentPage()) {
            return '<li class="item active"><a class="text" href="#">' . $page . '</a></li>';
        } else {
            return '<li class="item"><a class="text" href="' .
                $_SERVER['PHP_SELF'] . '?' .
                $this->config['querystring'] . '=' . $page .
                $this->addSearchToUrl() .
                '">' . $page . '</a></li>';
        }
    }
    
}



?>
<style>
    .main-nav {
        list-style: none;
        padding: 0;
    }

    .main-nav .item {
        display: inline-block;
        margin-right: 5px;
    }

    .main-nav .item a {
        text-decoration: none;
        padding: 5px 10px;
        border: 1px solid #ccc;
        background-color: #f2f2f2;
        color: #333;
    }

    .main-nav .item a:hover {
        background-color: #ddd;
    }

    .main-nav .item .page-input {
        width: 32.17px;
        height: 35px;
        padding: 5px 10px;
        text-align: center;
        border: 1px solid #ccc;
        background-color: #f2f2f2;
        color: #333;
    }

    .go-button {
        background-color: #4CAF50;
        /* Màu nền */
        color: white;
        /* Màu chữ */
        padding: 8px 20px;
        /* Kích thước */
        border: none;
        /* Không có viền */
        cursor: pointer;
        /* Con trỏ chuột */
        border-radius: 4px;
        /* Độ cong góc */
    }

    .go-button:hover {
        background-color: #45a049;
        /* Màu nền khi di chuột qua */
    }
</style>