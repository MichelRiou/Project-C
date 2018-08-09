SELECT products.product_id,products.product_builder,products.product_model,products.product_designation 
FROM `request_tags` 
left outer join product_tags on request_tags.tag_id = product_tags.tag_id 
left outer join products on product_tags.product_id=products.product_id
WHERE `request_id` in (3,4,5) and  product_tags.product_tag_numeric   <=  `request_tag_numeric`
GROUP BY products.product_id;