<h5>Система управления заказами</h5>
Порядок запуска:
1. Выбрать бд и задать его в .env.
2. Запустить миграцию и сид

Бд поделил на следующие таблицы:
<p>
1 - Таблица заказов ("orders")
(id,event_id,event_date,equal_price,created_at,updated_at)
</p>
<p>
2 - Таблица событий ("events)
(id,name,created_at,updated_at)
</p>
<p>
3 - Таблица билетов по заказам ("order_tickets")
(id,order_id,ticket_type,barcode,created_at,updated_at)
</p>
<p>
4 - Таблица типа заказов ("ticket_types")
(id,name,price,created_at,updated_at)
</p>
<p>
По моему предположению именно такая структура обеспечит гибкости системе и позволит создать сколько угодно дополнительных типов билетов.
А так же генерировать barcode на каждого из клиентов. Ну или скорее всего не так понял задачу)
<br>
Как и говорил hr'у, я никогда не использовал тесты в работе, поэтому мокал, через стандартные псевдометоды, а метод вызывал, через роут.
</p>
