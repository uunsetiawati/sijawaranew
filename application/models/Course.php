<?php

class Course extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->db->query("SET foreign_key_checks = 0;");
    }

    // QUERY GET DATA
    public function get_home_course($id_category)
    {
        $this->db->select('activity.*, course.DESKRIPSI_COURSE');
        $this->db->join('course', 'course.ID_ACTIVITY = activity.ID_ACTIVITY', 'left');
        $this->db->limit(3);
        $this->db->order_by('activity.LOG_TIME', 'desc');
        return $this->db->get_where('activity', $id_category)->result_array();
    }
    public function get_all_course()
    {
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 1])->result_array();
    }
    public function get_all_course_in($id)
    {
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 1, 'ID_USER' => $id])->result_array();
    }
    public function get_course_pagination($start = "", $limit = "", $condition)
    {
        $id_user = $this->session->userdata('ID_USER');
        if (!empty($id_user)) {
            $this->db->limit($start, $limit);
            $this->db->select('activity.*, course.DESKRIPSI_COURSE');
            $this->db->select("(
                SELECT 
                    COUNT(*)
                FROM
                    payment p
                LEFT JOIN `order` o ON 
                    o.ID_PAY  = p.ID_PAY 
                WHERE 
                    o.ID_USER = '" . $id_user . "'
                    AND 
                    o.ID_PRODUCT = `activity`.ID_ACTIVITY
                    AND 
                    p.DATE_PAY IS NOT NULL ) as DATA_CHECKING");
            $this->db->select("( CEIL(
                    ((
                        SELECT 
                            o.MAPPING_COUNT 
                        FROM 
                            `order` o 
                        WHERE 
                            o.ID_USER = 'USR_DMNb4b'
                            AND 
                            o.ID_PRODUCT = `activity`.ID_ACTIVITY
                    ) - 1)
                    /
                    (
                        SELECT
                            COUNT(*)
                        FROM
                            `mapping_course`
                        WHERE
                            `mapping_course`.ID_USER = 'USR_DMNb4b'
                            AND `mapping_course`.ID_ACTIVITY = `activity`.ID_ACTIVITY
                    ) * 100
                )
            )  as PROGRESS");
            $this->db->join('course', 'course.ID_ACTIVITY = activity.ID_ACTIVITY', 'left');
            return $this->db->get_where('activity', $condition)->result_array();
        } else {
            $this->db->limit($start, $limit);
            $this->db->select('activity.*, course.DESKRIPSI_COURSE');
            $this->db->join('course', 'course.ID_ACTIVITY = activity.ID_ACTIVITY', 'left');
            return $this->db->get_where('activity', $condition)->result_array();
        }
    }
    public function get_course($id_activity)
    {
        $this->db->select('activity.*, course.ID_COURSE, course.PENGUMUMAN, course.DESKRIPSI_COURSE, course.DESKRIPSI_COURSE_ITEM, course.SUMMARY');
        $this->db->select('user.NAME, user.FOTO_PROFILE, kategori.KATEGORI');
        $this->db->select("(
            SELECT 
                COUNT(*)
            FROM
                payment p
            LEFT JOIN `order` o ON 
                o.ID_PAY  = p.ID_PAY 
            WHERE 
                o.ID_USER = '" . $this->session->userdata('ID_USER') . "'
                AND 
                o.ID_PRODUCT = `activity`.ID_ACTIVITY
                AND 
                p.DATE_PAY IS NOT NULL ) as DATA_CHECKING");
        $this->db->join('course', 'course.ID_ACTIVITY = activity.ID_ACTIVITY', 'LEFT');
        $this->db->join('kategori', 'kategori.ID_KATEGORI = course.KATEGORI', 'LEFT');
        $this->db->join('user', 'user.ID_USER = activity.ID_USER', 'LEFT');
        $this->db->where('course.ID_ACTIVITY', $id_activity);
        return $this->db->get_where('activity', ['TYPE_ACTIVITY' => 1])->row_array();
    }
    public function get_course_by_id($keyword, $type)
    {
        $this->db->select('activity.*');
        $this->db->select("(
            SELECT
                COUNT(*)
            FROM
                `order`
            LEFT JOIN `transaction` ON
                `transaction`.ID_TRANS = `order`.ID_PAY
            WHERE
                `order`.ID_USER = '" . $this->session->userdata('ID_USER') . "'
                AND `order`.ID_PRODUCT = `activity`.ID_ACTIVITY
                AND `transaction`.STAT_BAYAR = 3 ) as DATA_CHECKING");
        if (!empty($keyword)) {
            $this->db->like('TITLE_ACTIVITY', $keyword);
        }
        $this->db->where('TYPE_ACTIVITY', $type);
        return $this->db->get('activity')->result_array();
    }
    public function get_item_course($condition)
    {
        $id_course = !empty($condition["ID_COURSE"]) ? '`item_course`.`ID_COURSE` = ' . $condition["ID_COURSE"] : '';
        $id_user = !empty($condition["ID_USER"]) ? '`mapping_course`.`ID_USER` = "' . $condition["ID_USER"] . '"' : '';
        $conditions = array_filter([$id_course, $id_user]);

        if (!empty($conditions)) {
            $condition = 'WHERE ' . implode(' AND ', $conditions);
        } else {
            $condition = '';
        }

        return $this->db->query("
            SELECT
                `item_course` .*,
                (
                    CASE WHEN 
                        (`item_course`.`ORDER_LIST` <= (
                            SELECT 
                                o.MAPPING_COUNT 
                            FROM 
                                `order` o 
                            WHERE 
                                o.ID_USER = mapping_course.ID_USER 
                                AND 
                                o.ID_PRODUCT = mapping_course.ID_ACTIVITY
                            )
                        ) 
                        THEN 1 ELSE 0 
                    END
                ) AS STATUS ,
                `mapping_course`.`ID_ACTIVITY`,
                `detail_quiz`.`SOAL`,
                `detail_quiz`.`PIL_JWB`,
                `detail_quiz`.`KUNCI`,
                `detail_quiz`.`ORDER_LIST` AS `SOAL_ORDER`
            FROM
                `item_course`
            LEFT JOIN `detail_quiz` ON
                `detail_quiz`.`ID_QUIZ` = `item_course`.`ID_ITEM`
            LEFT JOIN `mapping_course` ON
                `mapping_course`.`ID_ITEM` = `item_course`.`ID_ITEM`
                $condition
            GROUP BY
                `item_course`.`ID_ITEM`
        ")->result_array();
    }
    public function get_detail_item_course($condition, $type)
    {
        if ($type == 1) {
            $this->db->where($condition);
            return $this->db->get('item_course')->row_array();
        } else {
            $this->db->join('detail_quiz', 'detail_quiz.ID_QUIZ = item_course.ID_ITEM', 'left');
            $this->db->where($condition);
            return $this->db->get('item_course')->result_array();
        }
    }
    public function get_quiz_grade($id_quiz)
    {
        $id_user = $this->session->userdata('ID_USER');

        $this->db->where('nilai_quiz.ID_QUIZ', $id_quiz);
        $this->db->where('nilai_quiz.ID_USER', $id_user);
        return $this->db->get('nilai_quiz')->row_array();
    }
    public function get_correct_answer_item_course($id_detail, $pilih_jwbn)
    {
        $this->db->select('detail_quiz.ID_DETAIL');
        $this->db->where('detail_quiz.ID_DETAIL', $id_detail);
        $this->db->where('detail_quiz.KUNCI', $pilih_jwbn);
        return $this->db->count_all_results('detail_quiz');
    }
    public function get_last_item_course($id_activity, $id_item)
    {
        $id_user = $this->session->userdata('ID_USER');
        $conItem = (!empty($id_item)) ? "AND mc.ID_ITEM = '$id_item'" : "AND (CASE WHEN (ic.`ORDER_LIST` = o.MAPPING_COUNT) THEN 1 ELSE 0 END) = 1";
        return $this->db->query("
            SELECT
                mc.* ,
                ic.ORDER_LIST ,
                (CASE WHEN (ic.`ORDER_LIST` <= o.MAPPING_COUNT) THEN 1 ELSE 0 END) AS STATUS ,
                (CASE WHEN (ic.`ORDER_LIST` = o.MAPPING_COUNT) THEN 1 ELSE 0 END) AS STATUS_BTN
            FROM
                `mapping_course` mc
            LEFT JOIN item_course ic ON 
                ic.ID_ITEM = mc.ID_ITEM 
            LEFT JOIN `order` o ON 
                o.ID_USER = mc.ID_USER 
                AND 
                o.ID_PRODUCT = mc.ID_ACTIVITY 
            WHERE
                mc.`ID_USER` = '$id_user'
                AND 
                mc.`ID_ACTIVITY` = '$id_activity'
                $conItem
            ORDER BY
                mc.`ID_ITEM` ASC
        ")->result_array();
    }
    public function save_quiz_grade($id_quiz, $nilai)
    {
        $id_user = $this->session->userdata('ID_USER');

        $this->db->where('nilai_quiz.ID_QUIZ', $id_quiz);
        $this->db->where('nilai_quiz.ID_USER', $id_user);
        $total_data = $this->db->count_all_results('nilai_quiz');

        if ($total_data > 0) {
            $data_quiz = array(
                "ID_QUIZ" => $id_quiz,
                "ID_USER" => $id_user,
                "NILAI" => $nilai
            );
            $this->db->where('nilai_quiz.ID_QUIZ', $id_quiz);
            $this->db->where('nilai_quiz.ID_USER', $id_user);
            $this->db->update('nilai_quiz', $data_quiz);
        } else {
            $data_quiz = array(
                "ID_QUIZ" => $id_quiz,
                "ID_USER" => $id_user,
                "NILAI" => $nilai
            );
            return $this->db->insert('nilai_quiz', $data_quiz);
        }
    }
    public function get_all_materi($id_course)
    {
        return $this->db->get_where('item_course', ['ID_COURSE' => $id_course])->result_array();
    }
    public function get_all_question($id_quiz)
    {
        return $this->db->get_where('detail_quiz', ['ID_QUIZ' => $id_quiz])->result_array();
    }
    public function get_all_mapping($condition)
    {
        $id_user =  $condition["ID_USER"];
        $id_act =  $condition["ID_ACTIVITY"];
        return $this->db->query("
            SELECT 
                o.MAPPING_COUNT ,
                o.COURSE_COMPLETED
            FROM 
                `order` o 
            WHERE 
                o.ID_PRODUCT = '$id_act'
                AND 
                o.ID_USER = '$id_user'
        ")->row_array();
    }
    public function get_all_quiz($id_course)
    {
        return $this->db->get_where('quiz', ['ID_COURSE' => $id_course])->result_array();
    }
    public function get_all_quizDetail($id_materi)
    {
        return $this->db->get_where('detail_quiz', ['ID_COURSE' => $id_materi])->result_array();
    }

    // QUERY INSERT DATA
    public function InsertActivity($data)
    {
        $this->db->insert('activity', $data);
        return $this->db->affected_rows();
    }
    public function InsertCourse($data)
    {
        $this->db->insert('course', $data);
        return $this->db->affected_rows();
    }
    public function InsertItem($data)
    {
        $this->db->insert('item_course', $data);
        return $this->db->insert_id();
    }
    public function InsertQuiz($data)
    {
        $this->db->insert('quiz', $data);
        return $this->db->affected_rows();
    }
    public function InsertDetailQuiz($data)
    {
        $this->db->insert('detail_quiz', $data);
        return $this->db->affected_rows();
    }
    public function InsertQuizDetail($data)
    {
        $this->db->insert('detail_quiz', $data);
        return $this->db->affected_rows();
    }

    // QUERY UPDATE DATA
    public function updateMappingIndex($id_course, $id_activity)
    {
        $mapping = $this->db->get_where('mapping_course', ['ID_USER' => $this->session->userdata('ID_USER'), 'ID_ACTIVITY' => $id_activity])->result_array();
        $new_item = $this->db->get_where('item_course', ['ID_COURSE' => $id_course])->result_array();
        if (count($mapping) < count($new_item)) {
            for ($i = 0; $i < count($new_item); $i++) {
                if (!empty($mapping[$i]['ID_ITEM'])) {
                    $this->db->where('ID_MAPPING', $mapping[$i]['ID_MAPPING']);
                    $this->db->update('mapping_course', ['ID_ITEM' => $new_item[$i]['ID_ITEM']]);
                } else {
                    if ($i == 0) {
                        $data_mapping = array(
                            "ID_USER" => $this->session->userdata('ID_USER'),
                            "ID_ACTIVITY" => $id_activity,
                            "ID_ITEM" => $new_item[$i]['ID_ITEM'],
                            "STATUS" => 1
                        );
                    } else {
                        $data_mapping = array(
                            "ID_USER" => $this->session->userdata('ID_USER'),
                            "ID_ACTIVITY" => $id_activity,
                            "ID_ITEM" => $new_item[$i]['ID_ITEM'],
                            "STATUS" => 0
                        );
                    }
                    $this->db->insert('mapping_course', $data_mapping);
                }
            }
        } else {
            for ($i = 0; $i < count($mapping); $i++) {
                if (empty($new_item[$i]['ID_ITEM'])) {
                    $this->db->where('ID_MAPPING', $mapping[$i]['ID_MAPPING']);
                    $this->db->delete('mapping_course');
                } else {
                    $this->db->where('ID_MAPPING', $mapping[$i]['ID_MAPPING']);
                    $this->db->update('mapping_course', ['ID_ITEM' => $new_item[$i]['ID_ITEM']]);
                }
            }
        }
    }
    public function UpdateActivity($data, $id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->update('activity', $data);
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function UpdateCourse($data, $id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->update('course', $data);
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function UpdateMapping($condition)
    {
        $id_user = $condition['ID_USER'];
        $id_course = $condition['ID_PRODUCT'];
        $data_lastMapping = $this->db->query("
            SELECT 
                o.MAPPING_COUNT 
            FROM 
                `order` o 
            WHERE 
                o.ID_USER = '$id_user'
                AND 
                o.ID_PRODUCT = '$id_course'
        ")->row_array();

        $this->db->where($condition);
        $this->db->update('order', [
            'MAPPING_COUNT' => $data_lastMapping["MAPPING_COUNT"] + 1
        ]);
    }
    public function UpdateCourseFinish($condition)
    {
        $this->db->where($condition);
        $this->db->update('order', [
            'COURSE_COMPLETED' => 1
        ]);
    }

    // QUERY DELETE DATA
    public function DeleteItem($id_course)
    {
        $this->db->where('item_course.ID_COURSE', $id_course);
        $this->db->delete('item_course');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteActivity($id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->delete('activity');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteEvent($id_activity)
    {
        $this->db->where('ID_ACTIVITY', $id_activity);
        $this->db->delete('course');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteQuiz($id_course)
    {
        $this->db->where('quiz.ID_COURSE', $id_course);
        $this->db->delete('quiz');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteMateri($id_course)
    {
        $this->db->where('course.ID_COURSE', $id_course);
        $this->db->delete('course');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteDetailQuiz($id_course)
    {
        $this->db->where('detail_quiz.ID_COURSE', $id_course);
        $this->db->delete('detail_quiz');
        return $this->db->query("SET foreign_key_checks = 1;");
    }
    public function DeleteQuizPenilaian($condtion)
    {
        $this->db->where($condtion);
        $this->db->delete('nilai_quiz');
    }
}
