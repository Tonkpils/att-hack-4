class CasesController < ApplicationController
  before_filter :find_client

  def find_client
    @client = Client.where(id: params[:client_id]).first
  end
  # GET /cases
  # GET /cases.json
  def index
    @cases = @client ? @client.cases : Case.all

    respond_to do |format|
      format.html # index.html.erb
      format.json { render json: @cases }
    end
  end

  # GET /cases/1
  # GET /cases/1.json
  def show
    @case = @client.cases.find(params[:id])

    respond_to do |format|
      format.html # show.html.erb
      format.json { render json: @case }
    end
  end

  # GET /cases/new
  # GET /cases/new.json
  def new
    @case = @client.cases.build

    respond_to do |format|
      format.html # new.html.erb
      format.json { render json: @case }
    end
  end

  # GET /cases/1/edit
  def edit
    @case = Case.find(params[:id])
  end

  # POST /cases
  # POST /cases.json
  def create
    @case = @client.cases.create params[:case]

    project = Harvest::Project.new(name: @case.name, client_id: @client.harvest_id, billable: true, notes: @case.notes)
    project = $harvest.projects.create(project)
    task = $harvest.projects.create_task(project, "New Case Metting #{project.id}")

    @case.task_id = task.id
    @case.project_id = project.id
    @case.invoice_number = 1001

    respond_to do |format|
      if @case.save

        #entry = $harvest.entries
        format.html { redirect_to client_case_path(client_id: @client.id, id: @case.id), notice: 'Case was successfully created.' }
        format.json { render json: @case, status: :created, location: @case }
      else
        format.html { render action: "new" }
        format.json { render json: @case.errors, status: :unprocessable_entity }
      end
    end
  end

  # PUT /cases/1
  # PUT /cases/1.json
  def update
    @case = Case.find(params[:id])

    respond_to do |format|
      if @case.update_attributes(params[:case])
        format.html { redirect_to @case, notice: 'Case was successfully updated.' }
        format.json { head :no_content }
      else
        format.html { render action: "edit" }
        format.json { render json: @case.errors, status: :unprocessable_entity }
      end
    end
  end

  # DELETE /cases/1
  # DELETE /cases/1.json
  def destroy
    @case = Case.find(params[:id])
    @case.destroy

    respond_to do |format|
      format.html { redirect_to cases_url }
      format.json { head :no_content }
    end
  end

  def invoice
    @case = @client.cases.find(params[:case_id])
    number = rand(100000000)
    @case.invoice_number = number
    @case.save!
    invoice = Harvest::Invoice.new(
        subject: "Invoice for #{@client.name} case #{@case.name}",
        client_id: @client.harvest_id,
        issued_at: Time.now,
        due_at: Time.now.advance(days: 30),
        currency: "United States Dollars - USD",
        number: @case.invoice_number,
        notes: @case.notes,
        state: "draft",
        line_items: [Harvest::LineItem.new("kind" => "Service", "description" => "One item", "quantity" => 200, "unit_price" => "12.00")]
    )

    begin
      @invoice = $harvest.invoices.create(invoice)
    rescue
      invoice[:number] = @case.invoice_number
      @invoice = $harvest.invoices.create(invoice)
    end

    @case.update_attribute(:invoice_id, @invoice.id)

    render 'cases/invoice'
  end

  def show_invoice
  end
end
