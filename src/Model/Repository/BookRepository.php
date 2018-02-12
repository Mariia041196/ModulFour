<?php
// dependency injection
namespace Model\Repository;
use Model\Entity\Book;
class BookRepository
{
    /**
     * @var \PDO
     */
    protected $pdo;

    public function setPdo(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function count()
    {
        $sth = $this->pdo->query('select count(*) as count from book');
        return $sth->fetchColumn();
    }

    public function findAll(array $options = [], $hydrationArray = false)
    {
        $limitSql = '';

        if (isset($options['current_page']) && isset($options['items_on_page'])) {
            $page = $options['current_page'] - 1;
            $count = $page * $options['items_on_page'];
            $limitSql = "limit {$count}, {$options['items_on_page']}";
        }

        $collection = [];
        $sth = $this->pdo->query('select * from book ' . $limitSql);

        if ($hydrationArray) {
            return $res = $sth->fetchAll(\PDO::FETCH_ASSOC);
        }

        while ($res = $sth->fetch(\PDO::FETCH_ASSOC)) {
            $book = (new Book())
                ->setId($res['id'])
                ->setTitle($res['title'])
                ->setDescription($res['description'])
                ->setPrice($res['price'])
                ->setIsActive($res['is_active'])
                ->setCategory($res['category_id'])
            ;

            $collection[] = $book;
        }

        return $collection;
    }

    public function find($id)
    {
        $collection = [];
        $sth = $this->pdo->prepare('select * from book where id = :id');
        $sth->execute(['id' => $id]);

        $res = $sth->fetch(\PDO::FETCH_ASSOC);

        if (!$res) {
            return null;
        }

        return (new Book())
            ->setId($res['id'])
            ->setTitle($res['title'])
            ->setDescription($res['description'])
            ->setPrice($res['price'])
            ->setIsActive($res['is_active'])
            ->setCategory($res['category_id'])
            ;
    }
}