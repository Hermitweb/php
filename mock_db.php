<?php
// 模拟数据库操作类 - 绕过MySQL认证问题

class MockDB {
    private $data = [];
    
    public function __construct() {
        // 初始化模拟数据
        $this->initMockData();
    }
    
    private function initMockData() {
        // 管理员数据 - 使用password_hash加密
        $this->data['admin'] = [
            ['id' => 1, 'name' => 'admin', 'uid' => '123456', 'password' => password_hash('123456', PASSWORD_DEFAULT), 'phone' => '18894624507', 'email' => 'admin@php-news.com', 'regtime' => '2021-01-01 00:00:00', 'lastlogin' => null, 'stutas' => 1],
            ['id' => 2, 'name' => 'aaa', 'uid' => '666666', 'password' => password_hash('666666', PASSWORD_DEFAULT), 'phone' => '18894624507', 'email' => 'aaa@php-news.com', 'regtime' => '2021-01-02 00:00:00', 'lastlogin' => null, 'stutas' => 1],
        ];
        
        // 用户数据
        $this->data['user'] = [
            ['id' => 1, 'uid' => '123456', 'password' => 'e10adc3949ba59abbe56e057f20f883e', 'phone' => '12345678911', 'email' => '123456@qq.com', 'regtime' => '2021-01-01', 'stutas' => 1],
            ['id' => 2, 'uid' => '111111', 'password' => '96e79218965eb72c92a549dd5a33011', 'phone' => '11111111111', 'email' => '1111111111@qq.com', 'regtime' => '2021-01-02', 'stutas' => 1],
        ];
        
        // 文章数据
        $this->data['wen'] = [
            ['id' => 1, 'user' => '央视新闻', 'title' => '突然"变卦" 美军航母将继续在中东待命', 'jianjie' => '美国代理国防部长克里斯托弗·米勒近日表示，美海军"尼米兹"号航空母舰将改变原定返回美国的计划，继续在中东海域待命。', 'image' => null, 'leibie' => '政治', 'regtime' => '2021-01-05 19:45:17', 'content' => '<p>央视网消息：美国代理国防部长克里斯托弗·米勒近日表示，美海军"尼米兹"号航空母舰将改变原定返回美国的计划，继续在中东海域待命。</p>', 'pinglun' => 1, 'remen' => 0, 'stutas' => 1],
            ['id' => 2, 'user' => '央视新闻', 'title' => '所有的努力，都为长江更美好', 'jianjie' => '五年来，在以习近平同志为核心的党中央坚强领导下，沿江省市推进生态环境整治，促进经济社会发展全面绿色转型。', 'image' => null, 'leibie' => '政治', 'regtime' => '2021-01-05 14:58:04', 'content' => '<p>图为：长江三峡西陵峡秭归县水域。</p>', 'pinglun' => 1, 'remen' => 0, 'stutas' => 1],
            ['id' => 3, 'user' => '央视新闻', 'title' => '奋力推动长江经济带迈向高质量发展', 'jianjie' => '推动长江经济带发展是以习近平同志为核心的党中央作出的重大决策，是关系国家发展全局的重大战略。', 'image' => null, 'leibie' => '经济', 'regtime' => '2021-01-05 19:45:35', 'content' => '<p>推动长江经济带发展是以习近平同志为核心的党中央作出的重大决策。</p>', 'pinglun' => 1, 'remen' => 0, 'stutas' => 1],
            ['id' => 4, 'user' => '央视新闻', 'title' => '北京二百场疫情发布双向构建政府与公众互信', 'jianjie' => '1月3日，北京市新冠肺炎疫情防控工作第200场新闻发布会"如期而至"。', 'image' => null, 'leibie' => '政治', 'regtime' => '2021-01-05 19:44:51', 'content' => '<p>新华每日电讯评论员关桂峰</p>', 'pinglun' => 1, 'remen' => 0, 'stutas' => 1],
            ['id' => 5, 'user' => '新华社', 'title' => '中国经济稳健前行', 'jianjie' => '中国经济在复杂多变的国际环境中保持稳健发展态势。', 'image' => null, 'leibie' => '经济', 'regtime' => '2021-01-06 10:00:00', 'content' => '<p>中国经济展现强大韧性。</p>', 'pinglun' => 1, 'remen' => 1, 'stutas' => 1],
            ['id' => 6, 'user' => '人民日报', 'title' => '科技创新引领未来', 'jianjie' => '科技创新成为推动高质量发展的强大动力。', 'image' => null, 'leibie' => '科技', 'regtime' => '2021-01-06 11:00:00', 'content' => '<p>科技创新是第一生产力。</p>', 'pinglun' => 1, 'remen' => 0, 'stutas' => 1],
            ['id' => 7, 'user' => '央视新闻', 'title' => '民生保障持续改善', 'jianjie' => '民生保障水平不断提高，人民生活更加幸福。', 'image' => null, 'leibie' => '社会', 'regtime' => '2021-01-06 12:00:00', 'content' => '<p>民生为本，幸福中国。</p>', 'pinglun' => 1, 'remen' => 0, 'stutas' => 1],
            ['id' => 8, 'user' => '新华社', 'title' => '乡村振兴全面推进', 'jianjie' => '乡村振兴战略深入实施，农村面貌焕然一新。', 'image' => null, 'leibie' => '农业', 'regtime' => '2021-01-07 09:00:00', 'content' => '<p>乡村振兴，美丽家园。</p>', 'pinglun' => 1, 'remen' => 0, 'stutas' => 1],
            ['id' => 9, 'user' => '人民日报', 'title' => '文化自信日益增强', 'jianjie' => '文化事业繁荣发展，文化自信更加坚定。', 'image' => null, 'leibie' => '文化', 'regtime' => '2021-01-07 10:00:00', 'content' => '<p>文化自信，民族之魂。</p>', 'pinglun' => 1, 'remen' => 0, 'stutas' => 1],
            ['id' => 10, 'user' => '央视新闻', 'title' => '生态文明建设成效显著', 'jianjie' => '绿水青山就是金山银山，生态文明建设成果丰硕。', 'image' => null, 'leibie' => '环保', 'regtime' => '2021-01-07 11:00:00', 'content' => '<p>绿水青山，美丽中国。</p>', 'pinglun' => 1, 'remen' => 1, 'stutas' => 1],
        ];
    }
    
    public function getList($table, $where = ' 1 ', $limit = 10, $offset = 0) {
        if (!isset($this->data[$table])) {
            return [];
        }
        $data = $this->data[$table];
        return array_slice($data, $offset, $limit);
    }
    
    public function getOne($table, $where = ' 1 ') {
        if (!isset($this->data[$table])) {
            return null;
        }
        return $this->data[$table][0] ?? null;
    }
    
    public function get_rows($table, $where = ' 1 ') {
        if (!isset($this->data[$table])) {
            return 0;
        }
        return count($this->data[$table]);
    }
    
    public function add($table, $data) {
        if (!isset($this->data[$table])) {
            $this->data[$table] = [];
        }
        $maxId = 0;
        foreach ($this->data[$table] as $row) {
            if ($row['id'] > $maxId) {
                $maxId = $row['id'];
            }
        }
        $data['id'] = $maxId + 1;
        $this->data[$table][] = $data;
        return true;
    }
    
    public function update($table, $data, $where) {
        if (!isset($this->data[$table])) {
            return false;
        }
        foreach ($this->data[$table] as &$row) {
            if (strpos($where, 'id=' . $row['id']) !== false) {
                $row = array_merge($row, $data);
                return true;
            }
        }
        return false;
    }
    
    public function del($table, $where) {
        if (!isset($this->data[$table])) {
            return false;
        }
        foreach ($this->data[$table] as $key => $row) {
            if (strpos($where, 'id=' . $row['id']) !== false) {
                unset($this->data[$table][$key]);
                $this->data[$table] = array_values($this->data[$table]);
                return true;
            }
        }
        return false;
    }
}

// 创建全局实例
$mockDB = new MockDB();

// 模拟数据库函数
function connect($db_host, $db_user, $db_password, $db_name) {
    global $mockDB;
    return true;
}

function add($table, $data) {
    global $mockDB;
    return $mockDB->add($table, $data);
}

function update($table, $data, $where) {
    global $mockDB;
    return $mockDB->update($table, $data, $where);
}

function del($table, $where) {
    global $mockDB;
    return $mockDB->del($table, $where);
}

function getOne($table, $where = ' 1 ') {
    global $mockDB;
    return $mockDB->getOne($table, $where);
}

function getList($table, $where = ' 1 ', $limit = 10, $offset = 0) {
    global $mockDB;
    return $mockDB->getList($table, $where, $limit, $offset);
}

function get_rows($table, $where = ' 1 ') {
    global $mockDB;
    return $mockDB->get_rows($table, $where);
}
?>
