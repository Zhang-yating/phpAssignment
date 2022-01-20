1.index.php:
Index.php is to display the information about the products. The navigation bar is located at the bottom of the header and contains the link to the two web pages. Above the navi bar are three buttons, user can choose to filter the information by pick one or some product lines clicking the first button. On clicking it, the selection zone will appear. The other two buttons work similarly.

These three filter or sort options can not be applied at the same time, which means the user can not filter by product line and sorted the result in descreasing or increasing at the same time. The javascript function then is used to make sure these three button can't be clicked at the same time.

Once the user choose a way to sort or filte the product information and enter or select the sorting/filting condition, a form will be submit from the client side to the server side, and the parameter will be passed to php, then the according sql query will be generate and the table will be displayed.

The form for the sorted info by product line part is generated in using php to get the name of the product line instead of just hardcode the name.

Error handling is complished by catching pdoexception and the error information will be displayed.

2.reps.php
reps.php shows the information of the sales. On clicking the name of a sale, a new page will be loaded and display the customer information. This function is realised by GET, once clicking the name, a url with the id of this sale will be passed to the server side and the the according information will be displayed.

The order numbers of a sale are merged into one row. And the overflow of the table is set to scroll in case that the amount of order number is large and the table is then too wide.
   