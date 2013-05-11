class ClientsController < ApplicationController
  def index
    @client = Client.new
    @clients = Client.where(user_id: (current_user ? current_user.id : params[:user_id]))
  end

  def show

  end

  def create
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
