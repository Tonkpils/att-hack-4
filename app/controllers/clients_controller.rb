class ClientsController < ApplicationController
  def index
    @client = Client.new
    @clients = Client.all
  end

  def show

  end

  def create
    puts "PARAMS #{params.inspect}"
    client_params = params[:client]
    @client = Client.where(name: client_params[:name]).first_or_initialize
    if @client.new_record?
      @client.user_id = current_user.id
    end

    @client.save!
    redirect_to clients_url, notice: "Client #{@client.name} added"
  end

  def new

  end
end
