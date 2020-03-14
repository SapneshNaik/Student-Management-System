
# elixirEdu: Curriculum Module 
  
Developer: Sapnesh Naik *<sapnesh@kerneldev.com>*  
  
    
## Overview:  
  
elixirEdu provides a complete all-in-one solution to manage all aspects of a student in an academic institution.   
  
### Modules:  
  
 - **Base Module:**   
	 - **User Profile Picture:** Create, Update and Delete (*deletion allowed?*)
 
 - **Curriculum Management:**  
	 A Generic module which can accomodate any kind of cirriculum. Be it of School, College or Graduate or PG.
  
	 - **Course Module:**
		 - **Common:** Update/Delete(Archival) require a password.
		 
		 -  **Course Creation, Updation and View**
			 - Course is the top level abstraction of any degree or scheme
			 - A role will be created by the name of the course.
				 - This role can be assigned to whomsoever who needs high level info of this course.
			 - Ex:   BA, CBSE
			 - UI: A Form wizard and Table (with filters and search), Popup for delete
			 
		 - **Grade Creation, Updation, Deletion and View**
			 - Grade is the division of a course.
			 - A Grade can be deleted only if it does not have any terms
			 - A role will be created by the name of the course.
				 - This role can be assigned to whomsoever who needs high level info of this grade.
			 - Ex:   BA-1, BA-2,  1St Standard, Class1-12, etc.
			 - UI: A form wizard and Table  (with filters and search), Popup for delete
			 
		 - **Term Creation, Updation, Deletion and View**
			 - Term is a duration based division of the Grade.
			 - A Term can be deleted only if it does not have any students
			 - Ex: Sem1, Sem2, Year1
			 - UI: A Form wizard and Table  (with filters and search), Popup for delete
			 - Questions:
				 - *Should the term start automatically based on start date? / should it be manually started?*
				 
		- **Subject Creation, Updation & Deletion** 
			- Subject/lectures are independent assets which can be mapped to any term.
			- A teacher will not be mapped to a subject at this stage.
			- A role will be automatically created on creation of a subject.
				- *This role can later be assigned to a Teaching staff?  / Teachers for this role must be chosen now ??*
				- Ex: Role:Sub_Maths
			- A subject can be mapped to many terms across courses.
			 - A Subject can be deleted only if it does not have any terms/teachers associated with it.
			- Ex: Science, Mathematics, PE
			 - UI: A Form wizard and Table  (with filters and search), Popup for delete
		
		- **Assigning Subjects and Teachers to a Term (and removing)**
			- A subject will be assigned to a term
			- A teacher needs to be selected for a this assigned subject.
			- A Dropdown of teachers with thisperticular subject role can be provided or a different teacher can be selected (In which scenario the subject role will be automatically assigned to this teacher)
			- Removing/Updating will invalidate the time table (future module) and new time table needs to be generated.
			 - UI: A Form wizard and Table  (with filters and search), Popup for delete
			
		- **Assigning/Updating/Removing students to first term.**
			- Students will be allowed to be assigned to any of the terms.
			- *Can one student belong to multiple terms at the same time?*
			- Later students can be promoted to the next term (Manually) or a new Student can be added/removed to the current term at anytime.
			 - UI: A Form wizard and Table  (with filters and search), Popup for delete
		
	- **Examination Module:**
		- Creating an examination for a perticular Subject in a Perticular term
		- UI: A form wizard where admin will select one or more subjects add a category (existing or new).
		- UI: listing will be a table with advanced filtering (based on Grade, Course, Term, Time, Category etc)
		- *Question: Hall ticket generation required?*
		- An Exam will belog to a category (for easier tracking later)
			- Ex: Class test, weekly test, mid-term, Finals etc.
		- Examination details will be tracked individually.
			- Minimum marks, total marks,
			- *Question: An option to upload question paper pdf for future reference?*
		- Examination results will be tracked individually.
			- An option to generate a report card based on results?
		- An examination can be deleted only if ir does not have any results

  
    
### Permissions:

Cirriculum module will bring in these permissons to the SMS system:
 
|Course|Grade  | Term |Subject | Examination |
|--|--| ---|--| --|
|Register|Register|Register|Register|Register
|View All|View All|View All|View All|View All
|Update|Update|Update|Update|Update
|Archive/Delete|Archive/Delete|Archive/Delete|Archive/Delete|Archive/Delete






