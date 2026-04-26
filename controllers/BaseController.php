<?php
namespace Controllers;

use Smarty\Smarty;

enum SortType
{
    case TYPE_ASC;
    case TYPE_DESC;
}

enum FilterTipe
{
    case TYPE_DATE;
    case TYPE_INT;
}
abstract class BaseController
{
    protected $smarty;
    public function __construct()
    {
        $this->smarty = new Smarty();
    }

    protected function view(string $file, array $data = [])
    {
        $this->smarty->assign("file", $file);

        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }

        $this->smarty->display("../view/basetemplate.tpl");
    }

    public function getQuery(string $name, SortType|FilterTipe $type) : ?string
    {
        if (!isset($_GET[$name])) {
            return null;
        }

        $value = $_GET[$name];

        switch ($type) {
            case SortType::TYPE_ASC:
            case SortType::TYPE_DESC:
                if (strtolower($value) === 'asc' || strtolower($value) === 'desc') {
                    return strtolower($value);
                }
                break;
            case FilterTipe::TYPE_DATE:
                if (strtotime($value) !== false) {
                    return $value;
                }
                break;
            case FilterTipe::TYPE_INT:
                if (filter_var($value, FILTER_VALIDATE_INT) !== false) {
                    return $value;
                }
                break;
        }

        return null;
    }
}