<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Project extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('projects_activity');
        Schema::dropIfExists('projects_activity_actual');
        Schema::dropIfExists('projects_activity_disbursement');
        Schema::dropIfExists('projects_activity_expansion');
        Schema::dropIfExists('projects_activity_issue');
        Schema::dropIfExists('projects_activity_performance');
        Schema::dropIfExists('projects_actual');
        Schema::dropIfExists('projects_budget');
        Schema::dropIfExists('projects_document');
        Schema::dropIfExists('projects_document_actual');
        Schema::dropIfExists('projects_grouping');
        Schema::dropIfExists('projects_investment_actual');
        Schema::dropIfExists('projects_investment_actual_detail');
        Schema::dropIfExists('projects_investment_actual_header');
        Schema::dropIfExists('projects_investment_budget');
        Schema::dropIfExists('projects_plan');
        Schema::dropIfExists('projects_return');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('config_project_document');
        Schema::dropIfExists('config_project');
        Schema::dropIfExists('masters');

        Schema::create('contacts', function (Blueprint $table) {
            $table->unsignedBigInteger('contact_id')->autoIncrement();
            $table->string('prefix_code', 6)->nullable();
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->string('position', 100);
            $table->string('department_code', 6);
            $table->string('email_division')->nullable();
            $table->string('email')->nullable();
            $table->string('tel', 20)->nullable();
            $table->string('fax', 20)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updated_by');
        });

        Schema::create('masters', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('type', 100);
            $table->string('code', 6)->unique();
            $table->string('description');
            $table->boolean('actived')->default(1);
            $table->unsignedInteger('ranking')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('config_project', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('type_code', 6);
            $table->unsignedInteger('operating_duration');
            // Add constraint
            $table->foreign('type_code')->references('code')->on('masters');
        });

        Schema::create('config_project_document', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('type_code', 6);
            $table->string('document_code', 6);
            $table->tinyInteger('operating_duration_reset')->default(0);
            // Add constraint
            $table->foreign('document_code')->references('code')->on('masters');
        });

        Schema::create('projects', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->autoIncrement();
            $table->string('description');
            $table->unsignedBigInteger('project_parent')->nullable();
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->string('type_code', 6)->nullable();
            $table->string('status_code', 6)->nullable();
            $table->string('registration_number', 100)->nullable();
            $table->timestamp('book_issued_at')->nullable();
            $table->string('book_code', 6)->nullable();
            $table->string('book_number', 30)->nullable();
            $table->string('ministry_code', 6)->nullable();
            $table->string('division_code', 6)->nullable();
            $table->string('department_code', 6)->nullable();
            $table->string('investment_code', 6)->nullable();
            $table->timestamp('operating_begin')->useCurrent()->nullable();
            $table->timestamp('operating_deadline')->nullable();
            $table->string('area_level_code', 6)->nullable();
            $table->string('area')->nullable();
            $table->string('area_detail')->nullable();
            $table->float('budget')->nullable();
            $table->float('actual')->nullable();
            $table->string('plan_begin_day', 2)->nullable();
            $table->string('plan_begin_month', 2)->nullable();
            $table->string('plan_begin_year', 4)->nullable();
            $table->string('plan_end_day', 2)->nullable();
            $table->string('plan_end_month', 2)->nullable();
            $table->string('plan_end_year', 4)->nullable();
            $table->string('actual_begin_date', 20)->nullable();
            $table->string('actual_end_date', 20)->nullable();
            $table->text('proposal')->nullable();
            $table->text('story')->nullable();
            $table->text('objective')->nullable();
            $table->text('goal')->nullable();
            $table->string('userdefined1', 100)->nullable();
            $table->string('userdefined2', 100)->nullable();
            $table->string('userdefined3', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updated_by');
            // Add constraint
            $table->foreign('contact_id')->references('id')->on('users');
        });
        
        Schema::create('projects_activity', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('activity_code');
            $table->string('sub_activity_desc')->nullable();
            $table->string('period');
            $table->double('budget', 8, 4)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_activity_actual', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('expansion_id');
            $table->unsignedBigInteger('activity_code');
            $table->string('sub_activity_desc')->nullable();
            $table->boolean('selected')->default(0);
            $table->string('period', 4);
            $table->unsignedInt('month_begin')->default(10);
            $table->unsignedInt('month_end')->default(9);
            $table->double('budget', 8, 4)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
            $table->foreign('expansion_id')->references('id')->on('projects_activity_expansion');
        });

        Schema::create('projects_activity_budget', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('activity_code');
            $table->string('sub_activity_desc')->nullable();
            $table->boolean('selected')->default(0);
            $table->string('period', 4);
            $table->unsignedInt('month_begin')->default(10);
            $table->unsignedInt('month_end')->default(9);
            $table->double('budget', 8, 4)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_activity_disbursement', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('period', 4);
            $table->string('month', 2);
            $table->string('activity_code', 6);
            $table->double('budget', 8, 4)->default(0);
            $table->double('actual', 8, 4)->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->unique(['project_id','period', 'month', 'activity_code']);
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_activity_expansion', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('expansion_code', 6);
            $table->string('begin_date', 30);
            $table->string('end_date', 30);
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updated_by');
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
            $table->foreign('expansion_code')->references('code')->on('masters');
        });

        Schema::create('projects_activity_issue', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('issue_activity', 50);
            $table->string('issue_date', 7);
            $table->text('issue_desc');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_activity_performance', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('period', 4);
            $table->string('month', 2);
            $table->string('activity_code', 6);
            $table->float('budget')->default(0);
            $table->float('actual')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->unique(['project_id','period', 'month', 'activity_code']);
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_actual', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('investment_type', 100)->nullable();
            $table->tinyInteger('included_vat')->default(1);
            $table->float('capital')->default(0);
            $table->float('subsidy')->default(0);
            $table->float('loan')->default(0);
            $table->float('borrow')->default(0);
            $table->float('finance')->default(0);
            $table->float('bank')->default(0);
            $table->float('bond')->default(0);
            $table->float('revenue')->default(0);
            $table->float('fund')->default(0);
            $table->float('ppp')->default(0);
            $table->float('others')->default(0);
            $table->string('others_desc')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_budget', function (Blueprint $table) {
            $table->unsignedBigInteger('budget_id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('investment_type', 100)->nullable();
            $table->tinyInteger('included_vat')->default(1);
            $table->float('capital')->default(0);
            $table->float('subsidy')->default(0);
            $table->float('loan')->default(0);
            $table->float('borrow')->default(0);
            $table->float('finance')->default(0);
            $table->float('bank')->default(0);
            $table->float('bond')->default(0);
            $table->float('revenue')->default(0);
            $table->float('fund')->default(0);
            $table->float('ppp')->default(0);
            $table->float('others')->default(0);
            $table->string('others_desc')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_document', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('book_group_code', 6);
            $table->string('book_code', 6);
            $table->timestamp('imported_at');
            $table->string('detail')->nullable();
            $table->string('filename')->nullable();
            $table->string('extension')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updated_by');
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_document_actual', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('filename')->nullable();
            $table->string('filepath')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by');
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedBigInteger('updated_by');
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });
        
        Schema::create('projects_grouping', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->string('name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        Schema::create('projects_grouping_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->unsignedInteger('grouping_id');
            // Add constraint
            $table->unique(['project_id','grouping_id']);
            $table->foreign('project_id')->references('project_id')->on('projects');
            $table->foreign('grouping_id')->references('id')->on('projects_grouping');
        });

        Schema::create('projects_investment_actual', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('fund_code', 6);
            $table->float('actual')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_investment_actual_detail', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('period', 4);
            $table->string('month', 2);
            $table->string('fund_code', 6);
            $table->float('budget')->default(0);
            $table->float('actual')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->unique(['project_id','period', 'month', 'fund_code']);
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_investment_actual_header', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('investment_type', 100)->nullable();
            $table->tinyInteger('included_vat')->default(1);
            $table->string('remark')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_investment_budget', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('fund_code', 6);
            $table->float('budget')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_investment_budget_header', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('investment_type', 100)->nullable();
            $table->tinyInteger('included_vat')->default(1);
            $table->string('remark')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_plan', function (Blueprint $table) {
            $table->unsignedBigInteger('plan_id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('description');
            $table->string('duration', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        Schema::create('projects_return', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
            $table->unsignedBigInteger('project_id');
            $table->string('type', 20);
            $table->string('description');
            $table->float('value');
            $table->string('unit', 50)->nullable();
            $table->string('remark')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            // Add constraint
            $table->foreign('project_id')->references('project_id')->on('projects');
        });

        DB::statement('CREATE OR REPLACE VIEW v_projects AS
            SELECT		p.project_id
                        , p.description
                        , p.project_parent AS project_parent
                        , p.contact_id
                        , u.prefix_code
                        , pre.description AS prefix_desc
                        , u.name AS contact_fullname
                        , u.name AS fname
                        , u.name AS lname
                        , p.type_code
                        , typ.description AS type_desc
                        , p.status_code
                        , sts.description AS status_desc
                        , p.registration_number
                        , p.book_issued_at
                        , p.book_number
                        , p.book_code
                        , book.description AS book_desc
                        , p.ministry_code
                        , mis.description AS ministry_desc
                        , p.division_code
                        , divi.description AS division_desc
                        , p.department_code
                        , dep.description AS department_desc
                        , p.investment_code
                        , inv.description AS investment_desc
                        , p.operating_begin
                        , p.operating_deadline
                        , DATEDIFF(NOW(), p.operating_begin) AS operating_days
                        , p.area_level_code
                        , al.description AS area_level_desc
                        , p.area
                        , p.area_detail
                        , p.budget
                        , p.actual
                        , p.plan_begin_day
                        , p.plan_begin_month
                        , p.plan_begin_year
                        , p.plan_end_day
                        , p.plan_end_month
                        , p.plan_end_year
                        , p.proposal
                        , p.story
                        , p.objective
                        , p.goal
                        , p.created_at
                        , p.created_by
                        , p.updated_at
                        , p.updated_by
            FROM		projects p
            LEFT JOIN	users u
            ON			u.id	        =	p.contact_id
            LEFT JOIN	masters pre
            ON			pre.type		=	\'Prefix\'
            AND			pre.code		=	u.prefix_code
            LEFT JOIN	masters sts
            ON			sts.type		=	\'Status\'
            AND			sts.code		=	p.status_code
            LEFT JOIN	masters book
            ON			book.type		=	\'Book\'
            AND			book.code		=	p.book_code
            LEFT JOIN	masters mis
            ON			mis.type		=	\'Ministry\'
            AND			mis.code		=	p.ministry_code
            LEFT JOIN	masters divi
            ON			divi.type		=	\'Division\'
            AND			divi.code		=	p.division_code
            LEFT JOIN	masters dep
            ON			dep.type		=	\'DepartmentProject\'
            AND			dep.code		=	p.department_code
            LEFT JOIN	masters inv
            ON			inv.type		=	\'Investment\'
            AND			inv.code		=	p.investment_code
            LEFT JOIN	masters al
            ON			al.type		    =	\'AreaLevel\'
            AND			al.code	    	=	p.area_level_code
            LEFT JOIN	masters typ
            ON			typ.type	    =	\'ProjectType\'
            AND			typ.code	   	=	p.type_code
            WHERE       p.status_code   NOT IN (\'17009\')
        ');

        DB::statement('CREATE OR REPLACE VIEW v_projects_investment_actual AS
            SELECT		a.id
                        , a.project_id
                        , a.fund_code
                        , f.description AS fund_desc
                        , a.actual AS fund_value
                        , a.created_at
                        , a.updated_at
            FROM		projects_investment_actual a
            LEFT JOIN	masters f
            ON			f.type		=	\'SourceOfFund\'
            AND			f.code		=	a.fund_code
        ');

        DB::statement('CREATE OR REPLACE VIEW v_projects_investment_budget AS
            SELECT		b.id
                        , b.project_id
                        , b.fund_code
                        , f.description AS fund_desc
                        , b.budget AS fund_value
                        , b.created_at
                        , b.updated_at
            FROM		projects_investment_budget b
            LEFT JOIN	masters f
            ON			f.type		=	\'SourceOfFund\'
            AND			f.code		=	b.fund_code
        ');

        DB::statement('CREATE OR REPLACE VIEW v_projects_budget AS
            SELECT		b.budget_id
                        , b.project_id
                        , b.investment_type
                        , b.included_vat
                        , b.capital + b.subsidy + b.loan + b.borrow + b.finance + b.bank + b.bond + b.revenue + b.fund + b.ppp + b.others AS budget_all
                        , b.capital + b.subsidy + b.loan + b.borrow AS budget
                        , b.capital
                        , b.subsidy
                        , b.loan
                        , b.borrow
                        , b.finance + b.bank + b.bond AS loan_domestic
                        , b.finance
                        , b.bank
                        , b.bond
                        , b.revenue
                        , b.fund
                        , b.ppp
                        , b.others
                        , b.others_desc
                        , b.created_at
                        , b.updated_at
            FROM		projects_budget b
        ');

        DB::statement('CREATE OR REPLACE VIEW v_projects_activity_expansion AS
            SELECT		e.id
                        , e.project_id
                        , e.expansion_code
                        , m.description
                        , CASE WHEN e.expansion_code = \'40001\' 
                            THEN m.description 
                            ELSE CONCAT(m.description, \'ครั้งที่ \', ROW_NUMBER() OVER (PARTITION BY e.project_id, e.expansion_code ORDER BY e.created_at)) 
                        END AS description_full
                        , e.begin_date
                        , e.end_date
                        , e.created_at
                        , e.updated_at
            FROM		projects_activity_expansion e
            LEFT JOIN   masters m
            ON          m.type      =   \'Expansion\'
            AND         m.code      =   e.expansion_code
        ');

        DB::statement('CREATE OR REPLACE VIEW v_projects_document AS
            SELECT		d.id
                        , d.project_id
                        , d.book_group_code
                        , dcg.description AS book_group_desc
                        , d.book_code
                        , doc.description AS book_desc
                        , d.imported_at
                        , d.detail
                        , d.filename
                        , d.extension
                        , d.created_at
                        , d.created_by
                        , d.updated_at
                        , d.updated_by
            FROM		projects_document d
            LEFT JOIN	masters dcg
            ON			dcg.type		=	\'DocumentGroup\'
            AND			dcg.code		=	d.book_code
            LEFT JOIN	masters doc
            ON			doc.type		=	\'Document\'
            AND			doc.code		=	d.book_code
        ');

        DB::statement('CREATE OR REPLACE VIEW v_contacts AS
            SELECT		c.contact_id
                        , c.prefix_code
                        , pre.description AS prefix_desc
                        , CONCAT(c.fname, \' \', c.lname) AS fullname
                        , c.fname
                        , c.lname
                        , c.position
                        , c.department_code AS department_code
                        , dc.description AS department_desc
                        , c.email_division
                        , c.email
                        , c.tel
                        , c.fax
                        , c.created_at
                        , c.created_by
                        , c.updated_at
                        , c.updated_by
            FROM		contacts c
            LEFT JOIN	masters pre
            ON			pre.type		=	\'Prefix\'
            AND			pre.code		=	c.prefix_code
            LEFT JOIN	masters dc
            ON			dc.type		    =	\'DepartmentContact\'
            AND			dc.code	    	=	c.department_code
        ');

        DB::statement('CREATE OR REPLACE VIEW v_users AS
            SELECT		u.id
                        , u.prefix_code
                        , pre.description AS prefix_desc
                        , u.name AS fullname
                        , u.name AS fname
                        , u.name AS lname
                        , u.position
                        , u.department_code AS department_code
                        , dc.description AS department_desc
                        , u.email
                        , u.tel
                        , u.fax
                        , u.password
                        , u.role
                        , r.description AS role_desc
                        , u.created_at
                        , u.updated_at
            FROM		users u
            LEFT JOIN	masters pre
            ON			pre.type		=	\'Prefix\'
            AND			pre.code		=	u.prefix_code
            LEFT JOIN	masters dc
            ON			dc.type		    =	\'DepartmentContact\'
            AND			dc.code	    	=	u.department_code
            LEFT JOIN	masters r
            ON			r.type		    =	\'Role\'
            AND			r.code	    	=	u.role
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW v_contacts');
        DB::statement('DROP VIEW v_projects');
        DB::statement('DROP VIEW v_projects_activity_expansion');
        DB::statement('DROP VIEW v_projects_budget');
        DB::statement('DROP VIEW v_projects_document');
        Schema::dropIfExists('projects_activity');
        Schema::dropIfExists('projects_activity_actual');
        Schema::dropIfExists('projects_activity_disbursement');
        Schema::dropIfExists('projects_activity_expansion');
        Schema::dropIfExists('projects_activity_issue');
        Schema::dropIfExists('projects_activity_performance');
        Schema::dropIfExists('projects_actual');
        Schema::dropIfExists('projects_budget');
        Schema::dropIfExists('projects_document');
        Schema::dropIfExists('projects_document_actual');
        Schema::dropIfExists('projects_grouping');
        Schema::dropIfExists('projects_investment_actual');
        Schema::dropIfExists('projects_investment_actual_detail');
        Schema::dropIfExists('projects_investment_actual_header');
        Schema::dropIfExists('projects_investment_budget');
        Schema::dropIfExists('projects_plan');
        Schema::dropIfExists('projects_return');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('config_project_document');
        Schema::dropIfExists('config_project');
        Schema::dropIfExists('masters');
    }
}
