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

SELECT forms.form_category,product_tags.product_id, COUNT(*) as c FROM forms
			left outer join headers on forms.form_id=headers.header_form
            left outer join request on headers.header_id= request.request_header
			left outer join `request_tags` on request.request_id=request_tags.request_id
            left outer join product_tags on request_tags.tag_id = product_tags.tag_id  
            where forms.form_id=1 and request.`request_id` in ('1,2,3,4,5,6') 
            and (`request_tag_sign` = ">" and product_tags.product_tag_numeric > request_tags.request_tag_numeric 
            OR `request_tag_sign` = "<" and product_tags.product_tag_numeric < request_tags.request_tag_numeric 
            OR `request_tag_sign` = "=" and product_tags.product_tag_numeric = request_tags.request_tag_numeric 
            OR `request_tag_sign` = "EST" and product_tags.product_tag_value = request_tags.request_tag_value)  
            group by  product_tags.product_id

SELECT * FROM products LEFT OUTER JOIN (SELECT product_tags.product_id,forms.form_category as category, COUNT(*) as c FROM `request_tags` 
left outer join product_tags on request_tags.tag_id = product_tags.tag_id
 left outer join request on request_tags.request_id=request.request_id
 left outer join headers on request.request_header=headers.header_id
 left outer join forms on headers.header_form=forms.form_id
 where request_tags.`request_id` in ('.$requests.') 
and (`request_tag_sign` = ">" and product_tags.product_tag_numeric > request_tags.request_tag_numeric 
OR `request_tag_sign` = "<" and product_tags.product_tag_numeric < request_tags.request_tag_numeric 
OR `request_tag_sign` = "=" and product_tags.product_tag_numeric = request_tags.request_tag_numeric 
OR `request_tag_sign` = "EST" and product_tags.product_tag_value = request_tags.request_tag_value) group by product_tags.product_id) as t 
on products.product_id=t.product_id where products.product_category = t.category ORDER BY t.c DESC, products.product_builder ASC