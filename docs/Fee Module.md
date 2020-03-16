

# elixirEdu: Fee Module 
  
Developer: Sapnesh Naik *<sapnesh@kerneldev.com>*  
  
   
  
## Module Detail:  
  
 
 -  **Fee Structure Definition:**  
	 A fee structue will be assigned to each category's Grade of a course.
	 - The Fee structure for each category of a Grade may differ or remain same (UI option to duplicate one structure for all/multiple categories).
		 - Ex: One fee structure of RTE, a different one for Staff Ward
	 - Each fee structure can have multple Fees:
		 - Ex: Grade BA1->RTE->[Tution Fee, Pocket Expenses...]
	- Each Fee can be devided into One or more installments.
		- Each installment has a due date, installment amount and paid amount.
		- A partial payment against an installment is allowed.
	- If a *due date* and *extention period* of an installment is past and the amount paid for the installment is less than *penalty threshold*, A panalty amount will charged per week of the delay of the payment untill the threshold value is met.

- **Fee Collection:**
	 The fee collection is a backend documentation process for the collection of installments of a Fee.
	- Payment is to be made against an installment.
	- Partial payment against an installment is allowed.
	- Different Payment modes are supported RTGS/NEFT, DD, Cash etc.
	- A Discount can be applied to a payment.
		- Ex: Sibling Discount, Sports Quota, Merit Student.

- **Invoice:** (Required?)
	- An invoice will be generated and sent to Student/Parent email for a payment.
	- A Collective Invoice for a Installment which includes all partial payments can also be generated.
	- A Collection Invoice for a Fee which includes details for all Installments can also be generated.
  
	
    
## Permissions:

Fee module will bring in 20 more permissons to the elixirEdu system:
 
|Fee Structure|Fee| Installment|Payment| Invoice|
|--|--| ---|--| --|
|Create|Create|Create|Crate|Register
|View All|View All|View All|View All|View All
|Update|Update|Update|Update|Update
|Archive/Delete|Archive/Delete|Archive/Delete|Archive/Delete|Archive/Delete







