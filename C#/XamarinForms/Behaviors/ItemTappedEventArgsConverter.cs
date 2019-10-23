using System;
using System.Globalization;
using Xamarin.Forms;

namespace MVVM.Converters
{
    public class ItemTappedEventArgsConverter : IValueConverter
    {
        public object Convert(object value, Type targetType, object parameter, CultureInfo culture)
        {
            var eventArgs = value as ItemTappedEventArgs;
            if (eventArgs == null)
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
}