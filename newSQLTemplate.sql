SELECT * FROM `request_tags` left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
where `request_id` in (0,1,2,3,4,5,6) and `request_tag_sign` = ">=" and product_tags.product_tag_numeric >= request_tags.request_tag_numeric;

SELECT * FROM `request_tags` left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
where `request_id` in (0,1,2,3,4,5,6) and `request_tag_sign` = "EST" and product_tags.product_tag_value = request_tags.request_tag_value

SELECT * FROM `request_tags` left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
where `request_id` in (0,1,2,3,4,5,6) and `request_tag_sign` = "EST" and product_tags.product_tag_value = request_tags.request_tag_value

select t.product_id, count(*) from (SELECT product_tags.product_id FROM `request_tags` left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
where `request_id` in (0,1,2,3,4,5,6) and `request_tag_sign` = ">" and product_tags.product_tag_numeric > request_tags.request_tag_numeric 
UNION
SELECT product_tags.product_id FROM `request_tags` left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
where `request_id` in (0,1,2,3,4,5,6) and `request_tag_sign` = "<" and product_tags.product_tag_numeric < request_tags.request_tag_numeric 
UNION
SELECT product_tags.product_id FROM `request_tags` left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
where `request_id` in (0,1,2,3,4,5,6) and `request_tag_sign` = "=" and product_tags.product_tag_numeric = request_tags.request_tag_numeric 
UNION
SELECT product_tags.product_id FROM `request_tags` left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
where `request_id` in (0,1,2,3,4,5,6) and `request_tag_sign` = "EST" and product_tags.product_tag_value = request_tags.request_tag_value) as t group by t.product_id

SELECT product_tags.product_id, count(*) FROM `request_tags` left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
where `request_id` in (0,1,2,3,4,5,6) and (`request_tag_sign` = ">" and product_tags.product_tag_numeric > request_tags.request_tag_numeric OR `request_tag_sign` = "<" and product_tags.product_tag_numeric < request_tags.request_tag_numeric 
OR `request_tag_sign` = "=" and product_tags.product_tag_numeric = request_tags.request_tag_numeric OR `request_tag_sign` = "EST" and product_tags.product_tag_value = request_tags.request_tag_value)  group by  product_tags.product_id

select * from products left outer join (SELECT product_tags.product_id, count(*) as c FROM `request_tags` left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
where `request_id` in (0,1,2,3,4,5,6) and (`request_tag_sign` = ">" and product_tags.product_tag_numeric > request_tags.request_tag_numeric OR `request_tag_sign` = "<" and product_tags.product_tag_numeric < request_tags.request_tag_numeric 
OR `request_tag_sign` = "=" and product_tags.product_tag_numeric = request_tags.request_tag_numeric OR `request_tag_sign` = "EST" and product_tags.product_tag_value = request_tags.request_tag_value)  group by  product_tags.product_id) as t on products.product_id=t.product_id ORDER BY t.c DESC, products.product_builder ASC