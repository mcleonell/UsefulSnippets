# Bindable behavior
## EventToCommandBehavior
used to bind commands to views without command attributes.
### How to use
Let's say this Viewmodel contains a command that requires an object "ExampleParam" as parameter, the ObservableCollection is there to supply items to a list view.
```c#
// ExampleViewmodel.cs

public ICommand ExampleCommand => new Command<ExampleParam>(
    (args) => { 
        DoSomething();
});

public ObservableCollection<ExampleParam> { get; set; }
....
```

A list view doesn't have a command attribute, so we should use the EventToCommandBehavior class to trigger the command.

The attributes are:
- **EventName:** The event you want to forward to the command. *(Ex. ItemTapped)*
- **Command:** The command you want to fire. *(In this case ExampleCommand)*
- **CommandParameter:** The parameter you want to send. *(In this case the full object, this is done with the "." character)*

```xml
<!-- ExampleView.xaml -->

<ContentPage    ....
                ....
                xmlns:behaviors="clr-namespace:... .Behaviors">

    <ListView   ItemsSource="{Binding ExampleParams}">
        <ListView.Behaviors>
            <behaviors:EventToCommandBehavior EventName="ItemTapped" Command="{Binding ExampleCommand}" CommandParameter=".">
        </ListView.Behaviors>
    </Listview>
</ContentPage>
```

If We would leave the code like this, it would not work. Because by default EventToCommandBehavior will send the event args to your command *(Ex. NewCommand<ItemTappedEventArgs>)*. So to get the desired result we would need a custom IValueConverter.

This custom converter gets the CommandParameter from ItemTappedEventArgs.Item.

```c#
// ItempTappedEventArgsConverter.cs

public class ItemTappedEventArgsConverter : IValueConverter
{
    public object Convert(object value, Type targetType, object parameter, CultureInfo culture)
    {
        var eventArgs = value as ItemTappedEventArgs;
        if(eventArgs == null)
        {
            throw new ArgumentException("Wrong value, ItemTappedEventArgs expected", "value");
        }
        return eventArgs.Item;
    }

    // Convert back can remain empty, we will not use it
    public object ConvertBack(object value, Type targetType, object parameter, CultureInfo culture)
    {
        throw new NotImplementedException();
    }
}
```

We need to declare the custom converter as a static resource. We do this in the App.xaml.

```xml
<!-- App.xml -->

<Application    ....
                ....
                xmlns:converters="clr-namespace:... .Converters">
    <Application.Resources>
        <ResourceDictonary>
            <converters:ItemTappedEventArgsConverter x:Key="ItemTappedEventArgsConverter">
        </ResourceDictionary>
    </Application.Resources>
</Application>
```

The EventToCommandBehavior has an EventArgsConverter attribute, we can assign our custom converter to it.


```xml
<!-- ExampleView.xaml -->

<ContentPage    ....
                ....
                xmlns:behaviors="clr-namespace:... .Behaviors">

    <ListView   ItemsSource="{Binding ExampleParams}">
        <ListView.Behaviors>
            <behaviors:EventToCommandBehavior EventName="ItemTapped" Command="{Binding ExampleCommand}" CommandParameter="." EventArgsConverter="{StaticResource ItemTappedEventArgsConverter}">
        </ListView.Behaviors>
    </Listview>
</ContentPage>
```
#### Enjoy!
