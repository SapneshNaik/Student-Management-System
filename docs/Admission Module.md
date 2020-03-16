

# elixirEdu: Admission Module 
  
Developer: Sapnesh Naik *<sapnesh@kerneldev.com>*  
  
    
## Overview:  
  
elixirEdu provides a complete all-in-one solution to manage all aspects of a student in an academic institution.   
  
## Module Detail:  

 -   **Admission Details:**  
	 Student Admission acts as a bridging module between a Student and a Course.
	 
		- This module requires Student Registartion and Cirriculum Module.
		 - A Student can be admitted into multiple courses at the same time.
			  - Ex: A Student can be part of CBSE Course, Grade 6 and Go-Carting Course, Basic.
		 - A Student can be admitted into only one of the available grades for the Course, not multiple.
			 - Ex: A student cannot be part of the BA1 and BA2 at the same time.
		- An Admission will have a status associated with it to idenity if the Grade is InProgress / Completed / DroppedOut.
		- This status will change based on the actions which will be provided in the future features (Ex. Student Final record etc)

 - **Admission Flow:**
	 - **Creation:** The UI will be a form.
		 - The Admin shall select a Student and select one or more Course-Grade for the Student.
	- **View:** The UI will be a table
	- **Updation**:  Admin can select any of the admissions and can update the details. Using a Form.
	- **Removal**: An  Admission can only be removed if it  does not have any recorded fee payments.

    
## Permissions:

Admission module will bring in 3 more permissons to the elixirEdu system:
 

 1. Admit Student
 2. Remove Student Admission
 3. Update Student Admission

