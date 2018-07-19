
    <table class="table table-striped">
    @if($quotes->isEmpty())
        <tr>
            <td colspan="3"><h5>Nothing to output...</h5><td>
        </tr>
    @else
        <tr>
            <th>Quote</th>
            <th>Author</th>
            <th></th>
            <th></th>
        </tr>
        @foreach($quotes as $row)
            <tr>
                <td>{{ $row->quotes->quoteText }}</td>
                <td>{{ $row->quotes->quoteAuthor }}</td>
                <td>
                    <a href="{{ url('/quote/'.$row['quoteID']. '/edit') }}" class="btn btn-info">Edit</a>
                </td>
                <td>
                    <form>
                    <a href="{{ url('/quote/'.$row['quoteID']. '/delete') }}" class="btn btn-danger">Delete</a>
                    <form>
                </td>
            </tr>
        @endforeach
    @endif
    </table>
    @if(!$quotes->isEmpty())
    <div>
        {{ $quotes->links() }}
    </div>
    @endif
        <a href="{{ url('/addQuote') }}" class="btn btn-primary">Add Quote</a>
        <a href="{{ url('/api/addquote') }}" class="btn btn-primary">Add Quote From API</a>
    <br>